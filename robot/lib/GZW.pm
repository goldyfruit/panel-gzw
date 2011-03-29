##########################################################################
# Panel-GZW is a web hosting panel for Unix/Linux platforms.
# Copyright (C) 2005 - 2010  Gaëtan Trellu - goldyfruit@free.fr
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
package GZW;			# Module Name.
use DBI;
require Exporter;		# Load Exporter module.
use strict;				# Load strict module.

###################################################
# DATABASE INFORMATIONS.
###################################################
my $database = "panel-gzw";
my $prefix = "";
my $host = "localhost";
my $login = "root";
my $password = "password";

# Function "connection", connect the daemon to the database.
# In the script, this function is called by "GZW::Connection".
sub Connection {

	# Connect to the database.
	my $connection = "DBI:mysql:database=$database;host=$host";
	my $queryConnect = DBI->connect($connection, $login, $password) or die("Cannot open database $database...");

	return $queryConnect;

}

sub Prefix {

	return $prefix;

}

# Return true.
1;
