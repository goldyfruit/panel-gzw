##########################################################################
# Panel-GZW is a web hosting panel for Unix/Linux platforms.
# Copyright (C) 2005 - 2011  GoldZone Web - gaetan.trellu@goldzoneweb.info
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
###########################################################################
#
package DNS;                    # Module Name.
require Exporter;               # Load Exporter module.
use Shell qw(cp cat chown);                     # Allow to use some Shell commands.
use strict;                             # Load strict module.
use File::Copy;

my $rootDir = "/opt/panel-gzw/templates";
my $tplVhost = "$rootDir/apache/vhost.tpl";
my $tplZone = "$rootDir/bind/zone.tpl";
my $tplAZone = "$rootDir/bind/A_field.tpl";
my $tplNamed = "$rootDir/bind/named.tpl";

sub CreateDomainName {


	my $queryRobot = "SELECT * FROM robot ;";
	my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
	$executeSqlRobot->execute();

        while(my @arrayRobot = $executeSqlRobot->fetchrow_array){

		###################################################
		# CREATE NEW DOMAIN.
		###################################################
		if (($arrayRobot['2'] eq "DOMAIN") && ($arrayRobot['9'] eq "1")) {

			# Select all options from in the "options" table.
			# This options will be used by the robot replace the TAGS in the zone, named templates, etc...
			my $queryOptions = "SELECT * FROM options ;";
			my $executeOptions = GZW::Connection->prepare($queryOptions);
			$executeOptions->execute();

			# All options find in the "options" table are put in an array.
			my @arrayOptions = $executeOptions->fetchrow_array;

			###################################################
			# Apache Virtualhost.
			###################################################
			# Copy the "vhost.tpl" file in the "/tmp" directory.
			cp("$tplVhost /tmp");

			# Open in read/write the "vhost.tpl" file in "/tmp" directory.
			open VHOST,"+< /tmp/vhost.tpl" or die "[CREATE DOMAIN] Cannot open the file \"vhost.tpl\" : $!\n";

			# Create an array with the "VHOST" contents ("/tmp/vhost.tpl").
			my @arrayVhost = <VHOST>;

			# TEMPORAIRE !!
                        my $phpdir = "/srv/data/php5-fcgi/";

			# Replace all TAGS presents in "/tmp/vhost.tpl" by the values of the "robot" table.
			map {s/{{DOMAIN}}/$arrayRobot['1']/} @arrayVhost;
			map {s/{{EMAIL}}/$arrayRobot['4']/} @arrayVhost;
			map {s/{{ALIAS}}/www.$arrayRobot['1']/} @arrayVhost;
			map {s/{{PATH}}/$arrayOptions['7']/} @arrayVhost;
			map {s/{{LOG}}/$arrayOptions['45']/} @arrayVhost;
			map {s/{{UID}}/$arrayRobot['3']/} @arrayVhost;
			map {s/{{GID}}/$arrayRobot['3']/} @arrayVhost;
			map {s/{{PHPDIR}}/$phpdir/} @arrayVhost;

			# Check all the file ("/tmp/vhost.tpl").
			seek (VHOST, 0, 0);

			# Write the news values in "/tmp/vhost.tpl" (after replaced all TAGS).
			print VHOST @arrayVhost;

			# Close the file "/tmp/vhost.tpl"
			close VHOST;

			# Put the contents of "/tmp/vhost.tpl" at the end of the Apache virtualhost.
			cat("/tmp/vhost.tpl >> $arrayOptions['44']apache2/virtualhosts/$arrayRobot['3'].conf");

			###################################################
			# Bind Zone.
			###################################################
			# Create the serial of the zone with the "localtime" function.
			# We just use "$year", "$month" and "$day" variables.
			# The serial will looks like this : 2009102001
			my ($sec,$min,$hour,$day,$month,$year,$wday,$yday,$isdst) = localtime time;
			$year+=1900;
			$month++;

	        # If the day is less than 10 we put a 0.
	        # Example : 6 become 06 
			if ($day < 10) {
				$day = "0".$day;
			}

			# The serial is ready but we add "01", it's the first time that the zone is generate.
			my $serial = $year.$month.$day."01";

			# Replace "@" by "." (dot) in the admin email, it's necessary to put this email in the zone. 
			my $contactDns = $arrayOptions['39'];
			$contactDns =~ s/@/./;

			# Copy the "zone.tpl" file in the "/tmp" directory.
			cp("$tplZone /tmp");

			# Open in read/write the "zone.tpl" file in "/tmp" directory.
			open ZONE,"+< /tmp/zone.tpl" or die "[CREATE DOMAIN] Cannot open the file \"zone.tpl\" : $!\n";

			# Create an array with the "ZONE" contents ("/tmp/zone.tpl").
			my @arrayZone = <ZONE>;

			# Replace all TAGS presents in "/tmp/zone.tpl" by the values of the "robot" and "options" tables.
			map {s/{{DOMAIN}}/$arrayRobot['1']/} @arrayZone;
			map {s/{{SERIAL}}/$serial/} @arrayZone;
			map {s/{{CONTACT_DNS}}/$contactDns/} @arrayZone;
			map {s/{{NS1}}/$arrayOptions['8']/} @arrayZone;
			map {s/{{NS2}}/$arrayOptions['9']/} @arrayZone;
			map {s/{{NS3}}/$arrayOptions['10']/} @arrayZone;
			map {s/{{MX1}}/$arrayOptions['14']/} @arrayZone;
			map {s/{{MX2}}/$arrayOptions['15']/} @arrayZone;
			map {s/{{IPNS1}}/$arrayOptions['11']/} @arrayZone;
			map {s/{{IPNS2}}/$arrayOptions['12']/} @arrayZone;
			map {s/{{IPNS3}}/$arrayOptions['13']/} @arrayZone;
			map {s/{{IPMX1}}/$arrayOptions['16']/} @arrayZone;
			map {s/{{IPMX2}}/$arrayOptions['17']/} @arrayZone;
			map {s/{{IPWEB}}/$arrayOptions['48']/} @arrayZone;

			# Check all the file ("/tmp/zone.tpl").
			seek (ZONE, 0, 0);

			# Write the news values in "/tmp/zone.tpl" (after replaced all TAGS).
			print ZONE @arrayZone;

			# Close the file "/tmp/zone.tpl"
			close ZONE;

			# Put the contents of "/tmp/zone.tpl" in a new file (zone).
			# The file as the same name that the domain.
			# Example : panel-gzw.com.conf
			cat("/tmp/zone.tpl > $arrayOptions['18']$arrayRobot['1'].conf");

			###################################################
			# Bind configuration file "named.conf"
			###################################################
			# Copy the "named.tpl" file in the "/tmp" directory.
			cp("$tplNamed /tmp");

			# Open in read/write the "named.tpl" file in "/tmp" directory.
			open NAMED,"+< /tmp/named.tpl" or die "[CREATE DOMAIN] Cannot open the file \"named.tpl\" : $!\n";

			# Create an array with the "NAMED" contents ("/tmp/named.tpl").
			my @arrayNamed = <NAMED>;

			# Replace all TAGS presents in "/tmp/named.tpl" by the values of the "robot" and "options" tables.
			map {s/{{DOMAIN}}/$arrayRobot['1']/} @arrayNamed;
			map {s/{{PATH_ZONE}}/$arrayOptions['18']/} @arrayNamed;
			map {s/{{IPNS2}}/$arrayOptions['12']/} @arrayNamed;

			# Check all the file ("/tmp/named.tpl").
			seek (NAMED, 0, 0);

			# Write the news values in "/tmp/named.tpl" (after replaced all TAGS).
			print NAMED @arrayNamed;

			# Close the file "/tmp/named.tpl"
			close NAMED;

			# Put the contents of "/tmp/named.tpl" at the end of the "named.conf"
			cat("/tmp/named.tpl >> $arrayOptions['19']");

			my $queryUpdate = "UPDATE robot set status='0' WHERE data='$arrayRobot['1']' ;";
			my $executeUpdate = GZW::Connection->prepare($queryUpdate);
			$executeUpdate->execute();

			# Create the directory of the new domain with 755 permissions.
			my $domainDirectory = $arrayOptions['7'].$arrayRobot['3']."/websites/".$arrayRobot['1'];
			mkdir $domainDirectory, 0755;

			# Change the owner of the new directory.
			my $uid = $arrayRobot['3'];
			my $gid = $arrayRobot['3'];
			chown $uid, $gid, $domainDirectory;

			# Stop the SQL query.
			$executeOptions->finish;
		}
	}

	$executeSqlRobot->finish();

}

sub DeleteDomainName {

	my $queryRobot = "SELECT * FROM robot ;";
        my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
        $executeSqlRobot->execute();

        while(my @arrayRobot = $executeSqlRobot->fetchrow_array){

		###################################################
		# DELETE DOMAIN.
		###################################################
		if (($arrayRobot['2'] eq "DOMAIN") && ($arrayRobot['9'] eq "2")) {

			# Select all options from in the "options" table.
			# This options will be used by the robot replace the TAGS in the zone, named templates, etc...
			my $queryOptions = "SELECT * FROM options ;";
			my $executeOptions = GZW::Connection->prepare($queryOptions);
			$executeOptions->execute();

			# All options find in the "options" table are put in an array.
			my @arrayOptions = $executeOptions->fetchrow_array;

			###################################################
			# Bind configuration file "named.conf"
			###################################################
			# Open in read the "named.conf" file in "/etc/bind/" directory.
			open NAMED,"< $arrayOptions['19']" or die "[DELETE DOMAIN] Cannot open the file \"$arrayOptions['19']\" : $!\n";

			# Create a file "named.conf" in "/tmp" directory.
			# This file will be the new version of the "named.conf" after removing.
			open TMP_NAMED, "> /tmp/named.conf" or die "Cannot open the file : $!\n";

			# Process on many lines. Very important !!
			undef $/;

			# Check all the "named.conf" file.
			while (my $textNamed = <NAMED>) {

				# Remove the return ("\n").
				chomp($textNamed);

				# More simple to use it in the regular expression.
				my $domainName = $arrayRobot['1'];

				# Regular expression that will remove the text between tags BEGIN *** and END ***.
				$textNamed =~ s/\/\/BEGIN $domainName(.*?)\/\/END $domainName//sg;

				# Put everything in the new file (/tmp/named.conf).
				print(TMP_NAMED "$textNamed");
				print(TMP_NAMED "\n");
			}

			# Stop the process.
			$/ = "\n";

			# Close the files.
			close TMP_NAMED;
			close NAMED;

			# Put the contents of "/tmp/named.conf" at the end of the "/etc/bind/named.conf"
			cat("/tmp/named.conf > $arrayOptions['19']");

			###################################################
			# Bind Zone.
			###################################################
			# Delete the zone file.
			my $zoneFile = $arrayOptions['18'].$arrayRobot['1'].".conf";
			unlink($zoneFile);

			###################################################
			# Apache Virtualhost.
			###################################################
			# More simple to use it in the regular expression.
                   	my $domainName = $arrayRobot['1'];

			# Delete the domain name from virtualhost and put the result in a temp file.
			system "cat $arrayOptions['44']apache2/virtualhosts/$arrayRobot['3'].conf | sed \"/#BEGIN $domainName/,/#END $domainName/d\" > /tmp/vhosts.conf";

			# Put the contents of "/tmp/vhosts.conf" at the end of the virtualhost "XXXXX.conf".
                        cat("/tmp/vhosts.conf > $arrayOptions['44']apache2/virtualhosts/$arrayRobot['3'].conf");

			my $queryUpdate = "UPDATE robot set status='0' WHERE data='$arrayRobot['1']' ;";
			my $executeUpdate = GZW::Connection->prepare($queryUpdate);
			$executeUpdate->execute();

			# Stop the SQL query.
			$executeOptions->finish;

		}
	}

	$executeSqlRobot->finish();

}

sub EditDomainName {

	my $queryRobot = "SELECT * FROM robot ;";
        my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
        $executeSqlRobot->execute();

        while(my @arrayRobot = $executeSqlRobot->fetchrow_array){

		###################################################
		# EDIT DOMAIN.
		###################################################
		if (($arrayRobot['2'] eq "DOMAIN") && ($arrayRobot['9'] eq "3")) {

			# Select all options from in the "options" table.
			# This options will be used by the robot replace the TAGS in the zone, named templates, etc...
			my $queryOptions = "SELECT * FROM options ;";
			my $executeOptions = GZW::Connection->prepare($queryOptions);
			$executeOptions->execute();

			# All options find in the "options" table are put in an array.
			my @arrayOptions = $executeOptions->fetchrow_array;

			###################################################
			# Bind configuration file "named.conf"
			###################################################
			# More simple to use it in the regular expression.
                   	my $domainName = $arrayRobot['1'];

			# Contain the old domain name.
			my $oldDomainName = $arrayRobot['6'];

			# Edit the domain name from the named configuration and put the result in a temp file.
			system "cat $arrayOptions['19'] | sed \"s/$oldDomainName/$domainName/g\" > /tmp/named.conf";

			# Put the contents of "/tmp/named.conf" at the end of the "/etc/bind/named.conf"
			cat("/tmp/named.conf > $arrayOptions['19']");

			###################################################
			# Bind Zone.
			###################################################
			# Delete the zone file.
                        my $zoneFile = $arrayOptions['18'].$arrayRobot['6'].".conf";

			# Edit the domain name from the named configuration and put the result in a temp file.
                        system "cat $zoneFile | sed \"s/$oldDomainName/$domainName/g\" > /tmp/zone.conf";
			
			# Put the contents of "/tmp/named.conf" at the end of the "/etc/bind/named.conf"
			cat("/tmp/zone.conf > $zoneFile");

			# Rename the zone.
			move($arrayOptions['18'].$oldDomainName.".conf", $arrayOptions['18'].$domainName.".conf");

			###################################################
			# Apache Virtualhost.
			###################################################
			# Edit the domain name from virtualhost and put the result in a temp file.
			system "cat $arrayOptions['44']apache2/virtualhosts/$arrayRobot['3'].conf | sed \"s/$oldDomainName/$domainName/g\" > /tmp/vhosts.conf";

			# Put the contents of "/tmp/vhosts.conf" at the end of the virtualhost "XXXXX.conf".
                        cat("/tmp/vhosts.conf > $arrayOptions['44']apache2/virtualhosts/$arrayRobot['3'].conf");

			my $queryUpdate = "UPDATE robot set status='0' WHERE data='$arrayRobot['1']' ;";
			my $executeUpdate = GZW::Connection->prepare($queryUpdate);
			$executeUpdate->execute();

			# Stop the SQL query.
			$executeOptions->finish;

		}
	}

	$executeSqlRobot->finish();

}



sub CreateSubDomain {

        my $queryRobot = "SELECT * FROM robot ;";
        my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
        $executeSqlRobot->execute();

        while(my @arrayRobot = $executeSqlRobot->fetchrow_array){

		###################################################
		# CREATE NEW SUBDOMAIN.
		###################################################
		if (($arrayRobot['2'] eq "SUBDOMAIN") && ($arrayRobot['9'] eq "1")) {

			# Select all options from in the "options" table.
			# This options will be used by the robot replace the TAGS in the zone, named templates, etc...
			my $queryOptions = "SELECT * FROM options ;";
			my $executeOptions = GZW::Connection->prepare($queryOptions);
			$executeOptions->execute();

			# Create the serial of the zone with the "localtime" function.
			# We just use "$year", "$month" and "$day" variables.
			# The serial will looks like this : 2009102001
			my ($sec,$min,$hour,$day,$month,$year,$wday,$yday,$isdst) = localtime time;
			$year+=1900;
			$month++;

	        # If the day is less than 10 we put a 0.
	        # Example : 6 become 06 
			if ($day < 10) {
				$day = "0".$day;
			}
			
			# Generate a random number for the serial
			my $range = 100;
			my $randomNumber = int(rand($range));
			
			# The serial is ready but we add the generated number.
			my $serial = $year.$month.$day.$randomNumber;

			# All options find in the "options" table are put in an array.
			my @arrayOptions = $executeOptions->fetchrow_array;

			# Copy the "vhost.tpl" file in the "/tmp" directory.
			cp("$tplVhost /tmp");

			# Open in read/write the "vhost.tpl" file in "/tmp" directory.
			open VHOST,"+< /tmp/vhost.tpl" or die "[CREATE SUBDOMAIN] Cannot open the file \"vhost.tpl\" : $!\n";

			# Create an array with the "VHOST" contents ("/tmp/vhost.tpl").
			my @arrayVhost = <VHOST>;

			# TEMPORAIRE !!
			my $phpdir = "/srv/data/php5-fcgi/";

			# Replace all TAGS presents in "/tmp/vhost.tpl" by the values of the "robot" table.
			map {s/{{DOMAIN}}/$arrayRobot['1']/} @arrayVhost;
			map {s/{{EMAIL}}/$arrayRobot['4']/} @arrayVhost;
			map {s/{{ALIAS}}/www.$arrayRobot['1']/} @arrayVhost;
			map {s/{{PATH}}/$arrayOptions['7']/} @arrayVhost;
			map {s/{{LOG}}/$arrayOptions['45']/} @arrayVhost;
			map {s/{{UID}}/$arrayRobot['3']/} @arrayVhost;
			map {s/{{GID}}/$arrayRobot['3']/} @arrayVhost;
			map {s/{{PHPDIR}}/$phpdir/} @arrayVhost;
			
			# Check all the file ("/tmp/vhost.tpl").
			seek (VHOST, 0, 0);

			# Write the news values in "/tmp/vhost.tpl" (after replaced all TAGS).
			print VHOST @arrayVhost;

			# Close the file "/tmp/vhost.tpl"
			close VHOST;

			# Put the contents of "/tmp/vhost.tpl" at the end of the Apache virtualhost.
			cat("/tmp/vhost.tpl >> $arrayOptions['44']apache2/virtualhosts/$arrayRobot['3'].conf");

			# Select the domain name from the ID.
			my $queryDomainId = "SELECT name FROM domains WHERE id='$arrayRobot['5']' ;";
			my $executeDomaineId = GZW::Connection->prepare($queryDomainId);
			$executeDomaineId->execute();

			# Put the domain name in an array.
			my @arrayDomainId = $executeDomaineId->fetchrow_array;

			# Copy the "A_field.tpl" file in the "/tmp" directory.
			cp("$tplAZone /tmp");

			# Open in read/write the "A_field.tpl" file in "/tmp" directory.        
			open FIELD,"+< /tmp/A_field.tpl" or die "[CREATE SUBDOMAIN] Cannot open the file \"A_field.tpl\" : $!\n";

			# Create an array with the "FIELD" contents ("/tmp/A_field.tpl").
			my @arrayField = <FIELD>;

			# Replace all TAGS presents in "/tmp/A_field.tpl" by the values of the "robot" and "options" tables.
			map {s/{{SUBDOMAIN}}/$arrayRobot['1']/} @arrayField;
			map {s/{{IPWEB}}/$arrayOptions['48']/} @arrayField;

			# Check all the file ("/tmp/A_field.tpl").
			seek (FIELD, 0, 0);

			# Write the news values in "/tmp/A_field.tpl" (after replaced all TAGS).
			print FIELD @arrayField;

			# Close the file "/tmp/A_field.tpl"
			close FIELD;

			# Put the contents of "/tmp/A_field.tpl" at the end of zone.
			cat("/tmp/A_field.tpl >> $arrayOptions['18']$arrayDomainId['0'].conf");

			my $queryUpdate = "UPDATE robot set status='0' WHERE data='$arrayRobot['1']' ;";
			my $executeUpdate = GZW::Connection->prepare($queryUpdate);
			$executeUpdate->execute();

			# Create the directory of the new subdomain with 755 permissions.
			my $subdomainDirectory = $arrayOptions['7'].$arrayRobot['3']."/websites/".$arrayRobot['1'];
			mkdir $subdomainDirectory, 0755;

			# Change the owner of the new directory.
                        my $uid = $arrayRobot['3'];
                        my $gid = $arrayRobot['3'];
                        chown $uid, $gid, $subdomainDirectory;

			# Stop the SQL queries.
			$executeOptions->finish;
			$executeDomaineId->finish;
		}

        }

        $executeSqlRobot->finish();

}

sub DeleteSubDomain {

        my $queryRobot = "SELECT * FROM robot ;";
        my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
        $executeSqlRobot->execute();

        while(my @arrayRobot = $executeSqlRobot->fetchrow_array){

		###################################################
		# DELETE SUBDOMAIN.
		###################################################
		if (($arrayRobot['2'] eq "SUBDOMAIN") && ($arrayRobot['9'] eq "2")) {

			# Select all options from in the "options" table.
			# This options will be used by the robot replace the TAGS in the zone, named templates, etc...
			my $queryOptions = "SELECT * FROM options ;";
			my $executeOptions = GZW::Connection->prepare($queryOptions);
			$executeOptions->execute();

			# All options find in the "options" table are put in an array.
			my @arrayOptions = $executeOptions->fetchrow_array;

			# Create the serial of the zone with the "localtime" function.
			# We just use "$year", "$month" and "$day" variables.
			# The serial will looks like this : 2009102001
			my ($sec,$min,$hour,$day,$month,$year,$wday,$yday,$isdst) = localtime time;
			$year+=1900;
			$month++;

	        # If the day is less than 10 we put a 0.
	        # Example : 6 become 06 
			if ($day < 10) {
				$day = "0".$day;
			}
			
			# Generate a random number for the serial
			my $range = 100;
			my $randomNumber = int(rand($range));
			
			# The serial is ready but we add the generated number.
			my $serial = $year.$month.$day.$randomNumber;

			# Select the domain name from the ID.
			my $queryDomainId = "SELECT name FROM domains WHERE id='$arrayRobot['5']' ;";
			my $executeDomaineId = GZW::Connection->prepare($queryDomainId);
			$executeDomaineId->execute();

			# Put the domain name in an array.
			my @arrayDomainId = $executeDomaineId->fetchrow_array;

			###################################################
			# Bind zone file.
			###################################################
			# Open in read the zone file in "/var/cache/bind/" directory.
			open ZONE,"< $arrayOptions['18']$arrayDomainId['0'].conf" or die "[DELETE SUBDOMAIN] Cannot open the file $arrayOptions['18']$arrayDomainId['0'].conf : $!\n";

			# Create a zone file in "/tmp" directory.
			# This file will be the new version of the zone after removing.
			open TMP_ZONE, "> /tmp/$arrayDomainId['0'].conf" or die "[DELETE SUBDOMAIN] Cannot open the file \"$arrayDomainId['0'].conf\" : $!\n";

			# Process on many lines. Very important !!
			undef $/;

			# Check all the "named.conf" file.
			while (my $textZone = <ZONE>) {

				# Remove the return ("\n").
				chomp($textZone);

				# More simple to use it in the regular expression.
				my $subdomainName = $arrayRobot['1'];

				# Regular expression that will remove the text between tags BEGIN *** and END ***.
				$textZone =~ s/;BEGIN $subdomainName(.*?);END $subdomainName//sg;

				# Put everything in the new file ("/tmp/named.conf").
				print(TMP_ZONE "$textZone");
				print(TMP_ZONE "\n");
			}

			# Stop the process.
			$/ = "\n";

			# Close the files.
			close TMP_ZONE;
			close ZONE;

			# Put the contents of "/tmp/named.conf" at the end of the "/etc/bind/named.conf"
			cat("/tmp/$arrayDomainId['0'].conf > $arrayOptions['18']$arrayDomainId['0'].conf");

			###################################################
			# Apache Virtualhost.
			###################################################
			# Open in read the "named.conf" file in "/etc/bind/" directory.
			open VHOST,"< $arrayOptions['44']apache2/virtualhosts/$arrayRobot['3'].conf" or die "[DELETE SUBDOMAIN] Cannot open the file \"$arrayOptions['44']\" : $!\n";

			# Create a file "vhosts.conf" in "/tmp" directory.
			# This file will be the new version of the "vhosts.conf" after removing.
			open TMP_VHOST, "> /tmp/vhosts.conf" or die "[DELETE SUBDOMAIN] Cannot open the file \"vhosts.conf\" : $!\n";

			# Process on many lines. Very important !!
			undef $/;

			# Check all the "vhosts.conf" file.
			while (my $textVhost = <VHOST>) {

				# Remove the return ("\n").
				chomp($textVhost);

				# More simple to use it in the regular expression.
				my $subdomainName = $arrayRobot['1'];

				# Regular expression that will remove the text between tags BEGIN *** and END ***.
				$textVhost =~ s/#BEGIN $subdomainName(.*?)#END $subdomainName//sg;

				# Put everything in the new file ("/tmp/vhosts.conf").
				print(TMP_VHOST "$textVhost");
				print(TMP_VHOST "\n");
			}

			# Stop the process.
			$/ = "\n";

			# Close the files.
			close TMP_VHOST;
			close VHOST;

			# Put the contents of "/tmp/vhosts.conf" at the end of the "/etc/apache2/sites-available/vhosts.conf"
			cat("/tmp/vhosts.conf >> $arrayOptions['44']apache2/virtualhosts/$arrayRobot['3'].conf");

			my $queryUpdate = "UPDATE robot set status='0' WHERE data='$arrayRobot['1']' ;";
			my $executeUpdate = GZW::Connection->prepare($queryUpdate);
			$executeUpdate->execute();

			# Stop the SQL query.
			$executeOptions->finish;
			$executeDomaineId->finish;

		}

        }

        $executeSqlRobot->finish();

}

