#!/usr/bin/perl
use lib "/opt/panel-gzw/lib";
use DBI;                                        # Load the DBI module.
use GZW;                                                # Load GZW module, necessary to SQL connection.


        my $queryRobot = "SELECT * FROM options ;";
        my $executeCronRobot = GZW::Connection->prepare($queryRobot);
        $executeCronRobot->execute();


while (my $arrayRobot = $executeCronRobot->fetchrow_hashref) {
	print $arrayRobot->{name};
    }

         $executeCronRobot->finish();

