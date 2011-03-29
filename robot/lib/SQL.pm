##########################################################################
# Panel-GZW is a web hosting panel for Unix/Linux platforms.
# Copyright (C) 2005 - 2011 GoldZone Web - gaetan.trellu@goldzoneweb.info
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
use strict;			# Load strict module.

sub CreateDatabase {

	my $queryRobot = "SELECT * FROM " . GZW::Prefix() . "robot ;";
	my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
	$executeSqlRobot->execute();

        while(my $arrayRobot = $executeSqlRobot->fetchrow_hashref){

		# Select the SQL user name from the ID.
		my $querySqluser = "SELECT name FROM " . GZW::Prefix() . "sqlusers WHERE id='$arrayRobot->{user}' ;";
		my $executeSqlSqluser = GZW::Connection->prepare($querySqluser);
		$executeSqlSqluser->execute();

		# Put the SQL user name in an array.
		my $arraySqluser = $executeSqlSqluser->fetchrow_hashref;

		###################################################
		# CREATE NEW SQL DATABASE.
		###################################################
		if (($arrayRobot->{type} eq "SQLDATA") && ($arrayRobot->{status} eq "1")) {

			# Replace the "_" in the database name by "\_".
			# Example : "datas_user1" become "datas\_user1"
			my $databaseName = $arrayRobot->{data};
			$databaseName =~ s/_/\\_/;

			# Create the new SQL database.
			my $queryCreateData = "CREATE DATABASE `$arrayRobot->{data}` ;";

			# Give all privileges "$arraySqluser->{name}]" to on the new SQL database.
			my $queryGrant = "GRANT ALL PRIVILEGES ON `$databaseName` . * TO \'$arraySqluser->{name}\'@\'%\' WITH GRANT OPTION ;";

			my $executeSqlDataCreate = GZW::Connection->prepare($queryCreateData);
			my $executeGrant = GZW::Connection->prepare($queryGrant);

			# Execute the SQL queries.
			$executeSqlDataCreate->execute();
			$executeGrant->execute();

			my $queryUpdate = "UPDATE " . GZW::Prefix() . "robot set status='0' WHERE data='$arrayRobot->{data}' ;";
			my $qupdate = GZW::Connection->prepare($queryUpdate);
			$qupdate->execute();

		}

	}

	 $executeSqlRobot->finish();

}

sub CreateUser {

	my $queryRobot = "SELECT * FROM " . GZW::Prefix() . "robot ;";
	my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
	$executeSqlRobot->execute();

        while(my $arrayRobot = $executeSqlRobot->fetchrow_hashref){

                if (($arrayRobot->{type} eq "SQLUSER") && ($arrayRobot->{status} eq "1")) {

                        # Create the new SQL user.
                        my $queryCreateUser = "CREATE USER \'$arrayRobot->{data}\'@\'%\' IDENTIFIED BY \'$arrayRobot->{tmp}\' ;";

                        # Give the "USAGE" right to the new SQL user.
                        # It's possible to custom the quotas of queries, connections, etc...
                        my $queryGrant = "GRANT USAGE ON * . * TO \'$arrayRobot->{data}\'@\'%\' IDENTIFIED BY '$arrayRobot->{tmp}\' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;";

                        my $executeSqlUserCreate = GZW::Connection->prepare($queryCreateUser);
                        my $executeGrant = GZW::Connection->prepare($queryGrant);

                        # Execute the SQL queries.
                        $executeSqlUserCreate->execute();
                        $executeGrant->execute();

                        my $queryUpdate = "UPDATE " . GZW::Prefix() . "robot set tmp='', status='0' WHERE data='$arrayRobot->{data}' ;";
                        my $executeUpdate = GZW::Connection->prepare($queryUpdate);
                        $executeUpdate->execute();

                }

	}

	 $executeSqlRobot->finish();
}

sub DropDatabase {

	my $queryRobot = "SELECT * FROM " . GZW::Prefix() . "robot ;";
	my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
	$executeSqlRobot->execute();

	while(my $arrayRobot = $executeSqlRobot->fetchrow_hashref){

		# Select the SQL user name from the ID.
                my $querySqluser = "SELECT name FROM " . GZW::Prefix() . "sqlusers WHERE id='$arrayRobot->{user}' ;";
                my $executeSqlSqluser = GZW::Connection->prepare($querySqluser);
                $executeSqlSqluser->execute();

		# Put the SQL user name in an array.
                my $arraySqluser = $executeSqlSqluser->fetchrow_hashref;

		###################################################
                # DROP SQL DATABASE.
                ###################################################
                if (($arrayRobot->{type} eq "SQLDATA") && ($arrayRobot->{status} eq "2")) {

                        # Replace the "_" in the database name by "\_".
                        # Example : "datas_user1" become "datas\_user1"
                        my $databaseName = $arrayRobot->{data};
                        $databaseName =~ s/_/\\_/;

                        # Drop the SQL database.
                        my $queryDropData = "DROP DATABASE `$arrayRobot->{data}` ;";

                        # Remove all privileges on the SQL database.
                        my $queryRevokePrivileges = "REVOKE ALL PRIVILEGES ON `$databaseName` . * FROM \'$arraySqluser->{name}\'@\'%\' ;";

                        # Remove all rights on the SQL database.
                        my $queryRevokeGrant = "REVOKE GRANT OPTION ON `$databaseName` . * FROM \'$arraySqluser->{name}\'@\'%\' ;";

                        my $executeSqlDataDrop = GZW::Connection->prepare($queryDropData);
                        my $executeRevokePrivileges = GZW::Connection->prepare($queryRevokePrivileges);
                        my $executeRevokeGrant = GZW::Connection->prepare($queryRevokeGrant);

                        # Execute the SQL queries.
                        $executeSqlDataDrop->execute();
                        $executeRevokePrivileges->execute();
                        $executeRevokeGrant->execute();

                        my $queryUpdate = "UPDATE " . GZW::Prefix() . "robot set status='0' WHERE data='$arrayRobot->{data}' ;";
                        my $executeUpdate = GZW::Connection->prepare($queryUpdate);
                        $executeUpdate->execute();

                }
	}

	 $executeSqlRobot->finish();
}

sub DropUser {

	my $queryRobot = "SELECT * FROM " . GZW::Prefix() . "robot ;";
	my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
	$executeSqlRobot->execute();

        while(my $arrayRobot = $executeSqlRobot->fetchrow_hashref){

		###################################################
                # DROP SQL USER.
                ###################################################
                if (($arrayRobot->{type} eq "SQLUSER") && ($arrayRobot->{status} eq "2")) {

                        # Drop the SQL user.
                        my $queryDropUser = "DROP USER \'$arrayRobot->{data}\'@\'%\' ;";

                        my $executeSqlUserDrop = GZW::Connection->prepare($queryDropUser);

                        # Execute the SQL query.
                        $executeSqlUserDrop->execute();

                        my $queryUpdate = "UPDATE " . GZW::Prefix() . "robot set status='0' WHERE data='$arrayRobot->{data}' ;";
                        my $executeUpdate = GZW::Connection->prepare($queryUpdate);
                        $executeUpdate->execute();

                }

	}

	$executeSqlRobot->finish();
}

sub  ChangePassword {

	my $queryRobot = "SELECT * FROM " . GZW::Prefix() . "robot ;";
	my $executeSqlRobot = GZW::Connection->prepare($queryRobot);
	$executeSqlRobot->execute();

        while(my $arrayRobot = $executeSqlRobot->fetchrow_hashref){

		###################################################
                # CHANGE SQL USER PASSWORD.
                ###################################################
                if (($arrayRobot->{type} eq "SQLUSER") && ($arrayRobot->{status} eq "6")) {

                        # Change the SQL user password.
                        my $queryChangePassword = "SET PASSWORD FOR \'$arrayRobot->{data}\'@\'%\' = PASSWORD(\'$arrayRobot->{tmp}\') ;";

                        my $executeSqlChangePassword = GZW::Connection->prepare($queryChangePassword);

                        # Execute the SQL query.
                        $executeSqlChangePassword->execute();

                        my $queryUpdate = "UPDATE " . GZW::Prefix() . "robot set tmp='', status='0' WHERE data='$arrayRobot->{data}' ;";
                        my $executeUpdate = GZW::Connection->prepare($queryUpdate);
                        $executeUpdate->execute();

                }

	}

	$executeSqlRobot->finish();
}

# Return true.
1;
