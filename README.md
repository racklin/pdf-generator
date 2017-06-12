# Simple PDF Generator for Laravel

Simple PDF Generator for Laravel using tcpdf library.

This package using json as template and you can pass php array as data to generate PDF. 

It is useful to generate PDF for printing to preprint paper, ex `Invoice`.
 
# Installation
```json
{
    "require": {
        "racklin/pdf-generator": "dev-master"
    }
}
```

Next, add the service provider to `config/app.php`.

```php
'providers' => [
    //...
    Racklin\PdfGenerator\ServiceProvider::class,
]

//...

'aliases' => [
	//...
	'PDFGen' => Racklin\PdfGenerator\Facades\PdfGenerator::class
]

```

# Example
```
$pdf = new PdfGenerator();

$pdf->generate('example_01.json', ["name"=>"rack", "cname"=>"阿土伯"], '/tmp/example.pdf', 'F');
```
## Laravel Facade 
```
PDFGen::generate('example_01.json', ["name"=>"rack", "cname"=>"阿土伯"], '/tmp/example.pdf', 'F');
```

## Laravel version

Current package version works for Laravel 5+.

## License
MIT: https://racklin.mit-license.org/
