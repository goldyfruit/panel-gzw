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
package CRON;			# Module Name.
require Exporter;		# Load Exporter module.
use strict;			# Load strict module.

sub CreateJob {

	my $queryRobot = "SELECT * FROM " . GZW::Prefix() . "robot ;";
	my $executeCronRobot = GZW::Connection->prepare($queryRobot);
	$executeCronRobot->execute();

        while(my $arrayRobot = $executeCronRobot->fetchrow_hashref){

		###################################################
		# CREATE CRON JOB.
		###################################################
		if (($arrayRobot->{type} eq "CRON") && ($arrayRobot->{status} eq "1")) {

			my $job = $arrayRobot->{data};
			my $jobName = uc($arrayRobot->{tmp});

			system "su - $arrayRobot->{user} -c '(crontab -l; echo -e \"#BEGIN CRON $jobName\n$job\n#END CRON $jobName\") | crontab -'";
			my $queryUpdate = "UPDATE " . GZW::Prefix() . "robot set status='0' WHERE data='$arrayRobot->{data}' ;";
			my $qupdate = GZW::Connection->prepare($queryUpdate);
			$qupdate->execute();

		}

	}

	 $executeCronRobot->finish();

}

sub DeleteJob {

	my $queryRobot = "SELECT * FROM " . GZW::Prefix() . "robot ;";
	my $executeCronRobot = GZW::Connection->prepare($queryRobot);
	$executeCronRobot->execute();

	while(my $arrayRobot = $executeCronRobot->fetchrow_hashref){

		###################################################
		# DELETE CRON JOB.
		###################################################
		if (($arrayRobot->{type} eq "CRON") && ($arrayRobot->{status} eq "2")) {

			my $jobName = uc($arrayRobot->{data});

			system "su - $arrayRobot->{user} -c '(crontab -l | sed \"/#BEGIN CRON $jobName/,/#END CRON $jobName/d\") | crontab -'";
			my $queryUpdate = "UPDATE " . GZW::Prefix() . "robot set status='0' WHERE data='$arrayRobot->{data}' ;";
			my $qupdate = GZW::Connection->prepare($queryUpdate);
			$qupdate->execute();

		}

	}

	$executeCronRobot->finish();

}

# Return true
1;
