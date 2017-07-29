<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DietdataTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DietdataTable Test Case
 */
class DietdataTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DietdataTable
     */
    public $Dietdata;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.dietdata'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Dietdata') ? [] : ['className' => DietdataTable::class];
        $this->Dietdata = TableRegistry::get('Dietdata', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Dietdata);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
