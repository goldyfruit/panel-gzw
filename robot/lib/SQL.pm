##########################################################################
# Panel-GZW is a web hosting panel for Unix/Linux platforms.
# Copyright (C) 2005 - 2009  Gaëtan Trellu - goldyfruit@free.fr
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
package SQL;			# Module Name.
require Exporter;		# Load Exporter module.
use strict;				# Load strict module.

sub CreateDatabase {


	my $queryRobot = "SELECT * FROM robot ;";
	my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
	$executeSqlRobot->execute();

        while(my @arrayRobot = $executeSqlRobot->fetchrow_array){

		# Select the SQL user name from the ID.
		my $querySqluser = "SELECT name FROM sqlusers WHERE id='$arrayRobot['3']' ;";
		my $executeSqlSqluser = GZW::Connection->prepare($querySqluser);
		$executeSqlSqluser->execute();

		# Put the SQL user name in an array.
		my @arraySqluser = $executeSqlSqluser->fetchrow_array;

		###################################################
		# CREATE NEW SQL DATABASE.
		###################################################
		if (($arrayRobot['2'] eq "SQLDATA") && ($arrayRobot['9'] eq "1")) {

			# Replace the "_" in the database name by "\_".
			# Example : "datas_user1" become "datas\_user1"
			my $databaseName = $arrayRobot['1'];
			$databaseName =~ s/_/\\_/;

			# Create the new SQL database.
			my $queryCreateData = "CREATE DATABASE `$arrayRobot['1']` ;";

			# Give all privileges "$arraySqluser['0']" to on the new SQL database.
			my $queryGrant = "GRANT ALL PRIVILEGES ON `$databaseName` . * TO \'$arraySqluser['0']\'@\'%\' WITH GRANT OPTION ;";

			my $executeSqlDataCreate = GZW::Connection->prepare($queryCreateData);
			my $executeGrant = GZW::Connection->prepare($queryGrant);

			# Execute the SQL queries.
			$executeSqlDataCreate->execute();
			$executeGrant->execute();

			my $queryUpdate = "UPDATE robot set status='0' WHERE data='$arrayRobot['1']' ;";
			my $qupdate = GZW::Connection->prepare($queryUpdate);
			$qupdate->execute();

		}

	}

	 $executeSqlRobot->finish();

}

sub CreateUser {

	my $queryRobot = "SELECT * FROM robot ;";
	my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
	$executeSqlRobot->execute();

        while(my @arrayRobot = $executeSqlRobot->fetchrow_array){

                if (($arrayRobot['2'] eq "SQLUSER") && ($arrayRobot['9'] eq "1")) {

                        # Create the new SQL user.
                        my $queryCreateUser = "CREATE USER \'$arrayRobot['1']\'@\'%\' IDENTIFIED BY \'$arrayRobot['6']\' ;";

                        # Give the "USAGE" right to the new SQL user.
                        # It's possible to custom the quotas of queries, connections, etc...
                        my $queryGrant = "GRANT USAGE ON * . * TO \'$arrayRobot['1']\'@\'%\' IDENTIFIED BY '$arrayRobot['6']\' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;";

                        my $executeSqlUserCreate = GZW::Connection->prepare($queryCreateUser);
                        my $executeGrant = GZW::Connection->prepare($queryGrant);

                        # Execute the SQL queries.
                        $executeSqlUserCreate->execute();
                        $executeGrant->execute();

                        my $queryUpdate = "UPDATE robot set tmp='', status='0' WHERE data='$arrayRobot['1']' ;";
                        my $executeUpdate = GZW::Connection->prepare($queryUpdate);
                        $executeUpdate->execute();

                }

	}

	 $executeSqlRobot->finish();
}

sub DropDatabase {

	my $queryRobot = "SELECT * FROM robot ;";
	my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
	$executeSqlRobot->execute();

	while(my @arrayRobot = $executeSqlRobot->fetchrow_array){

		# Select the SQL user name from the ID.
                my $querySqluser = "SELECT name FROM sqlusers WHERE id='$arrayRobot['3']' ;";
                my $executeSqlSqluser = GZW::Connection->prepare($querySqluser);
                $executeSqlSqluser->execute();

		# Put the SQL user name in an array.
                my @arraySqluser = $executeSqlSqluser->fetchrow_array;

		###################################################
                # DROP SQL DATABASE.
                ###################################################
                if (($arrayRobot['2'] eq "SQLDATA") && ($arrayRobot['9'] eq "2")) {

                        # Replace the "_" in the database name by "\_".
                        # Example : "datas_user1" become "datas\_user1"
                        my $databaseName = $arrayRobot['1'];
                        $databaseName =~ s/_/\\_/;

                        # Drop the SQL database.
                        my $queryDropData = "DROP DATABASE `$arrayRobot['1']` ;";

                        # Remove all privileges on the SQL database.
                        my $queryRevokePrivileges = "REVOKE ALL PRIVILEGES ON `$databaseName` . * FROM \'$arraySqluser['0']\'@\'%\' ;";

                        # Remove all rights on the SQL database.
                        my $queryRevokeGrant = "REVOKE GRANT OPTION ON `$databaseName` . * FROM \'$arraySqluser['0']\'@\'%\' ;";

                        my $executeSqlDataDrop = GZW::Connection->prepare($queryDropData);
                        my $executeRevokePrivileges = GZW::Connection->prepare($queryRevokePrivileges);
                        my $executeRevokeGrant = GZW::Connection->prepare($queryRevokeGrant);

                        # Execute the SQL queries.
                        $executeSqlDataDrop->execute();
                        $executeRevokePrivileges->execute();
                        $executeRevokeGrant->execute();

                        my $queryUpdate = "UPDATE robot set status='0' WHERE data='$arrayRobot['1']' ;";
                        my $executeUpdate = GZW::Connection->prepare($queryUpdate);
                        $executeUpdate->execute();

                }
	}

	 $executeSqlRobot->finish();
}

sub DropUser {

	my $queryRobot = "SELECT * FROM robot ;";
	my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
	$executeSqlRobot->execute();

        while(my @arrayRobot = $executeSqlRobot->fetchrow_array){

		###################################################
                # DROP SQL USER.
                ###################################################
                if (($arrayRobot['2'] eq "SQLUSER") && ($arrayRobot['9'] eq "2")) {

                        # Drop the SQL user.
                        my $queryDropUser = "DROP USER \'$arrayRobot['1']\'@\'%\' ;";

                        my $executeSqlUserDrop = GZW::Connection->prepare($queryDropUser);

                        # Execute the SQL query.
                        $executeSqlUserDrop->execute();

                        my $queryUpdate = "UPDATE robot set status='0' WHERE data='$arrayRobot['1']' ;";
                        my $executeUpdate = GZW::Connection->prepare($queryUpdate);
                        $executeUpdate->execute();

                }

	}

	$executeSqlRobot->finish();
}

sub  ChangePassword {

	my $queryRobot = "SELECT * FROM robot ;";
	my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
	$executeSqlRobot->execute();

        while(my @arrayRobot = $executeSqlRobot->fetchrow_array){

		###################################################
                # CHANGE SQL USER PASSWORD.
                ###################################################
                if (($arrayRobot['2'] eq "SQLUSER") && ($arrayRobot['9'] eq "6")) {

                        # Change the SQL user password.
                        my $queryChangePassword = "SET PASSWORD FOR \'$arrayRobot['1']\'@\'%\' = PASSWORD(\'$arrayRobot['6']\') ;";

                        my $executeSqlChangePassword = GZW::Connection->prepare($queryChangePassword);

                        # Execute the SQL query.
                        $executeSqlChangePassword->execute();

                        my $queryUpdate = "UPDATE robot set tmp='', status='0' WHERE data='$arrayRobot['1']' ;";
                        my $executeUpdate = GZW::Connection->prepare($queryUpdate);
                        $executeUpdate->execute();

                }

	}

	$executeSqlRobot->finish();
}

# Return true.
1;
