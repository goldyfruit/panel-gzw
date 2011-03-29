#!/usr/bin/perl -w
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
package QUOTAS;			# Module Name.
require Exporter;		# Load Exporter module.
use strict;			# Load strict module.
use GZW;

my $trafficLog = "/var/log/apache2/traffic.log";

# Select some informations about the user.
my $queryUser = "SELECT id,name,offer_id FROM " . GZW::Prefix() . "users WHERE profile_id='2' ;";
my $executeUser = GZW::Connection->prepare($queryUser);
$executeUser->execute();

while(my $arrayUser = $executeUser->fetchrow_hashref) {

########
#	my $bandwidth = `cat $trafficLog | awk '{ SUM += \$NF} END { print SUM/1024/1024}'`;

#	my $queryCurrentTraffic = "UPDATE " . GZW::Prefix() . "quotasprogresses set bandwidth='$bandwidth' WHERE user_id='$arrayUser['0']' ;";
#	my $executeCurrentTraffic = GZW::Connection->prepare($queryCurrentTraffic);
#	$executeCurrentTraffic->execute();
#######

	#########################
	#	DISK SPACE	#
	#########################
	# With Linux "quota" and "awk" commands, we get the disk space use by the user.
	my $diskspace = `quota -u $arrayUser->{name} | awk 'END { print }' | awk -F " " '{ print \$1 }' | awk '{ SUM += \$NF} END { print SUM/1024 }'`;

	# Update the disk space use by the user.
	my $queryCurrentSpace = "UPDATE " . GZW::Prefix() . "quotasprogresses SET diskspace='" . $diskspace . "' WHERE user_id='" . $arrayUser->{id} . "' ;";
	my $executeCurrentSpace = GZW::Connection->prepare($queryCurrentSpace);
        $executeCurrentSpace->execute();

	# Get the disk quota for the user offer.
	my $querySpaceQuota = "SELECT diskspace FROM " . GZW::Prefix() . "quotas WHERE offer_id='" . $arrayUser->{offer_id} . "' ;";
	my $executeSpaceQuota = GZW::Connection->prepare($querySpaceQuota);
	$executeSpaceQuota->execute();

	# Get the disk space use by the user.
	my $querySpaceProgress = "SELECT diskspace FROM " . GZW::Prefix() . "quotasprogresses WHERE user_id='$arrayUser->{id}' ;";
        my $executeSpaceProgress = GZW::Connection->prepare($querySpaceProgress);
        $executeSpaceProgress->execute();

	# Loop who check quota status.
	while ((my $arraySpaceQuota = $executeSpaceQuota->fetchrow_hashref) && (my $arraySpaceProgress = $executeSpaceProgress->fetchrow_hashref)) {

		# We declare a warning, 0.90 equal 90%.
		my $diskQuotaWarn = ($arraySpaceQuota->{diskspace} * 0.90);

		# If the user is above 90% of his disk space quota, we change a flag in the table.
		# This flag will be use for an alert.
		if ($arraySpaceProgress->{diskspace} ge $diskQuotaWarn) {

			# Update the status field for the user.
			my $querySpaceStatus = "UPDATE " . GZW::Prefix() . "quotasprogresses set status='1' WHERE user_id='" . $arrayUser->{id} . "' ;";
                        my $executeSpaceStatus = GZW::Connection->prepare($querySpaceStatus);
                        $executeSpaceStatus->execute();

		}

	}

}

$executeUser->finish();
