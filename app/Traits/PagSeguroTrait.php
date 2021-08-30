<?php

namespace App\Traits;

use SimpleXMLElement;

trait PagSeguroTrait
{
    private function simpleXmlToArray(SimpleXMLElement $xmlObject, $out = [])
    {
        foreach ($xmlObject as $index => $node) {
            if (count($node) === 0) {
                $out[$node->getName()] = $node->__toString();
            } else {
                $out[$node->getName()][] = $this->simpleXmlToArray($node);
            }
        }
        return $out;
    }
}
