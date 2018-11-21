<?php
class account extends links {
    public function getsign($nature, $type)
    {

        if ($type=="debit"){

                    if ($nature=="assets" || $nature=="expense" || $nature=="cogs")
                    {
                        $sign="+";
                    }else
                    {
                        $sign="-";

                    }

                    return $sign;
        }
    elseif ($type=="credit"){

    if ($nature=="assets" || $nature=="expense" || $nature=="cogs")	             {
        $sign="-";
    }else {
        $sign="+";
    }

    return $sign;
    }





    }
}