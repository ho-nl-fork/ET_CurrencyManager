<?php

class ET_CurrencyManager_Test_Model_Currency extends EcomDev_PHPUnit_Test_Case
{
    /**
     * Product price round test
     *
     * @test
     */
    //public function testFormat($options, $unformattedNumber)
    public function testFormat()
    {
        //* @------loadFixture testFormat.yaml
        //* dataProvider dataProvider
        $this->setCurrentStore('default');


        $handle = fopen(dirname(__FILE__). "/Currency/" .
            "testFormat.csv", "r");

        fgetcsv($handle);
        $cnt = 0;
        while (($data = fgetcsv($handle)) !== FALSE) {
            //if ($cnt < 16561) { $cnt++; continue; }
            $options['expected'] = $data[0];
            $options['unformattedNumber'] = $data[1];
            $options['precision'] = $data[2];
            $options['min_decimal_count'] = $data[3];
            $options['cutzerodecimal'] = $data[4];
            $options['cutzerodecimal_suffix'] = $data[5];
            $options['zerotext'] = $data[6];
            $options['display'] = $data[7];
            $options['position'] = $data[8];

            print_r($data);

            // TODO: надо чистить все значения из настроек.


            Mage::app()->getStore('default')->resetConfig();
            Mage::app()->getStore('default')->setConfig('currencymanager/general/precision', $options['precision']);
            Mage::app()->getStore('default')->setConfig('currencymanager/general/min_decimal_count',
                $options['min_decimal_count']);
            Mage::app()->getStore('default')->setConfig('currencymanager/general/cutzerodecimal',
                $options['cutzerodecimal']);
            Mage::app()->getStore('default')->setConfig('currencymanager/general/cutzerodecimal_suffix',
                $options['cutzerodecimal_suffix']);
            Mage::app()->getStore('default')->setConfig('currencymanager/general/zerotext', $options['zerotext']);
            Mage::app()->getStore('default')->setConfig('currencymanager/general/position', $options['position']);
            Mage::app()->getStore('default')->setConfig('currencymanager/general/display', $options['display']);

            /*$symbolreplace = serialize(array(
                'currency' => array("USD"),
                'zerotext' => array($options['zerotext']),
            ));*/

            //Mage::app()->getStore('default')->setConfig('currencymanager/general/symbolreplace', $symbolreplace);


            echo "\nNumber of string " . (++$cnt) . "\n";
            echo "options setted before test + readet display from config\n";

            Mage::helper("currencymanager")->resetOptions();
            Mage::helper("currencymanager")->setOptions("USD");


            //var_dump(Mage::app()->getStore()->getId());
            $result = Mage::app()->getStore()->getBaseCurrency()->format($options['unformattedNumber'], array(), false);
            if (strcmp($options['expected'], $result) != 0) {
                print "result: " . $result . "\n" .
                    "expected: " . $options['expected'] . "\n" .
                    "value: " . $options['unformattedNumber'] . "\n" .

                    "-----------------------\n";
                return;
            } else {
                print "result: " . $result . "\n";
                print "-----------------------\n";
            }

        }

    }

}