<?php

class ccSourceFreeCurrencyRatesApi extends ccSourceBase
{
    /**
     * @param CurrencyCalcItem $object
     *
     * @return bool|float
     */
    public function run(CurrencyCalcItem $object)
    {
        $is_updated = false;
        $from = $object->get('from');
        $to = $object->get('to');

        $content = file_get_contents('https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/' . strtolower($from) . '.json');
        if (!empty($content)) {
            $data = $this->modx->fromJSON($content);
            $rate = @$data[strtolower($from)][strtolower($to)];
            if (!empty($rate)) {
                $object->set('rate', $rate);
                $object->set('updatedon', time());
                $is_updated = true;
            }
        }

        return $is_updated;
    }
}