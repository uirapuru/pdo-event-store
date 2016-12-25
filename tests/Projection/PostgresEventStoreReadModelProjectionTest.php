<?php
/**
 * This file is part of the prooph/pdo-event-store.
 * (c) 2016-2016 prooph software GmbH <contact@prooph.de>
 * (c) 2016-2016 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ProophTest\EventStore\PDO\Projection;

use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\Common\Messaging\NoOpMessageConverter;
use Prooph\EventStore\PDO\PersistenceStrategy\PostgresSimpleStreamStrategy;
use Prooph\EventStore\PDO\PostgresEventStore;
use ProophTest\EventStore\PDO\TestUtil;

/**
 * @group pdo_pgsql
 */
class PostgresEventStoreReadModelProjectionTest extends PDOEventStoreReadModelProjectionTestCase
{
    protected function setUp(): void
    {
        if (TestUtil::getDatabaseVendor() !== 'pdo_pgsql') {
            throw new \RuntimeException('Invalid database vendor');
        }

        $this->connection = TestUtil::getConnection();
        $this->connection->exec(file_get_contents(__DIR__.'/../../scripts/postgres/01_event_streams_table.sql'));
        $this->connection->exec(file_get_contents(__DIR__.'/../../scripts/postgres/02_projections_table.sql'));

        $this->eventStore = new PostgresEventStore(
            new FQCNMessageFactory(),
            new NoOpMessageConverter(),
            TestUtil::getConnection(),
            new PostgresSimpleStreamStrategy()
        );
    }
}
