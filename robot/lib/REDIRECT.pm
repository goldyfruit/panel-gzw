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
package REDIRECT;                    # Module Name.
require Exporter;               # Load Exporter module.
use Shell qw(cp cat chown);                     # Allow to use some Shell commands.
use strict;                             # Load strict module.
use File::Copy;

my $rootDir = "/opt/panel-gzw/templates";
my $tplRedirect = "$rootDir/redirect/alias.tpl";

sub CreateRedirection {

	my $queryRobot = "SELECT * FROM " . GZW::Prefix() . "robot ;";
	my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
	$executeSqlRobot->execute();

        while(my $arrayRobot = $executeSqlRobot->fetchrow_hashref){

		###################################################
		# CREATE NEW REDIRECTION.
		###################################################
		if (($arrayRobot->{type} eq "REDIRECT") && ($arrayRobot->{status} eq "1")) {

			# Select all options from in the "options" table.
			# This options will be used by the robot replace the TAGS in the zone, named templates, etc...
			my $queryOptions = "SELECT * FROM " . GZW::Prefix() . "options ;";
			my $executeOptions = GZW::Connection->prepare($queryOptions);
			$executeOptions->execute();

			# All options find in the "options" table are put in an array.
			my $arrayOptions = $executeOptions->fetchrow_hashref;

			system 'cat ' . $arrayOptions->{vhost_path} . 'apache2/virtualhosts/' . $arrayRobot->{user} . '.conf | sed "/ServerAlias/a\        # BEGIN {{ALIAS}}\n        ServerAlias {{ALIAS}}\n        # END {{ALIAS}}" | sed "s/{{ALIAS}}/' . $arrayRobot->{data} . '/" > /tmp/toto.conf';

			my $queryUpdate = "UPDATE " . GZW::Prefix() . "robot set status='0' WHERE data='" . $arrayRobot->{data} . "' ;";
			my $executeUpdate = GZW::Connection->prepare($queryUpdate);
			$executeUpdate->execute();

			# Stop the SQL query.
			$executeOptions->finish;

		}
	}

	$executeSqlRobot->finish();

}		

sub DeleteRedirection {

	my $queryRobot = "SELECT * " . GZW::Prefix() . "FROM robot ;";
        my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
        $executeSqlRobot->execute();

        while(my $arrayRobot = $executeSqlRobot->fetchrow_hashref){

		###################################################
		# DELETE REDIRECTION.
		###################################################
		if (($arrayRobot->{type} eq "REDIRECT") && ($arrayRobot->{status} eq "2")) {

			# Select all options from in the "options" table.
			# This options will be used by the robot replace the TAGS in the zone, named templates, etc...
			my $queryOptions = "SELECT * FROM " . GZW::Prefix() . "options ;";
			my $executeOptions = GZW::Connection->prepare($queryOptions);
			$executeOptions->execute();

			# All options find in the "options" table are put in an array.
			my $arrayOptions = $executeOptions->fetchrow_hashref;

			###################################################
			# Apache Virtualhost.
			###################################################
			# More simple to use it in the regular expression.
                   	my $redirectionName = $arrayRobot->{data};

			# Delete the domain name from virtualhost and put the result in a temp file.
			system "cat $arrayOptions->{vhost_path}apache2/virtualhosts/$arrayRobot->{user}.conf | sed \"/#BEGIN $redirectionName/,/#END $redirectionName/d\" > /tmp/toto.conf";

			my $queryUpdate = "UPDATE " . GZW::Prefix() . "robot set status='0' WHERE data='" . $arrayRobot->{data} . "' ;";
			my $executeUpdate = GZW::Connection->prepare($queryUpdate);
			$executeUpdate->execute();

			# Stop the SQL query.
			$executeOptions->finish;

		}
	}

	$executeSqlRobot->finish();

}

