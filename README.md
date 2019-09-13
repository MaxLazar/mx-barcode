# MX Barcode
![MX Barcode](/resources/img/mx-barcode.png)

Generate a barcode in ExpressionEngine

## Installation ##

* Place the **mx_barcode** folder inside your **user/addons** folder
* Go to **cp/addons** and install *MX Barcode*.

## Tags ##

	{exp:mx_barcode}

### Parameters  ###

	<img src="{exp:mx_barcode  data="2134124213" base64_encode="yes" color="#000000" format="svg" random}" alt="Bar code"/>

1. **data**: number or alphanumeric depending on the barcode type.
2. **format**: svg or png (default: svg)
3. **type**: see below for all accepted types (default: C128)
4. **width** factor: this set with width factor of the bars (default: 2)
5. **height**: the in pixels of the bars (default: 30)
6. **color**: the hex value of the bars (default: '#000000')
7. **base64_encode**: base64 for inline images (default: yes)
8. **filename**: filename for not-inline images (default: timestamp)

### Barcode Types ###


| Code     | Name                     |
| -------- | ------------------------ |
| C39      | CODE_39                  |
| C39+     | CODE_39_CHECKSUM         |
| C39E     | CODE_39E                 |
| C39E+    | CODE_39E_CHECKSUM        |
| C93      | CODE_93                  |
| S25      | STANDARD_2_5             |
| S25+     | STANDARD_2_5_CHECKSUM    |
| I25      | INTERLEAVED_2_5          |
| I25+     | INTERLEAVED_2_5_CHECKSUM |
| C128     | CODE_128                 |
| C128A    | CODE_128_A               |
| C128B    | CODE_128_B               |
| C128C    | CODE_128_C               |
| EAN2     | EAN_2                    |
| EAN5     | EAN_5                    |
| EAN8     | EAN_8                    |
| EAN13    | EAN_13                   |
| UPCA     | UPC_A                    |
| UPCE     | UPC_E                    |
| MSI      | MSI                      |
| MSI+     | MSI_CHECKSUM             |
| POSTNET  | POSTNET                  |
| PLANET   | PLANET                   |
| RMS4CC   | RMS4CC                   |
| KIX      | KIX                      |
| IMB      | IMB                      |
| CODABAR  | CODABAR                  |
| CODE11   | CODE_11                  |
| PHARMA   | PHARMA_CODE              |
| PHARMA2T | PHARMA_CODE_TWO_TRACKS   |


## Support Policy ##

This is Communite Edition (CE) add-on.

## Contributing To MX Barcode ##

Your participation to MX Barcode development is very welcome!

You may participate in the following ways:

* [Report issues](https://github.com/MaxLazar/mx-barcode/issues)


## License ##

The MX Barcode for ExpressionEngine is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

## Thanks To ##
