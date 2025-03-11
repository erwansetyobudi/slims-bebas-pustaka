# How to
Example code:
```php
<?php
use SLiMS\Pdf\Factory;
use SLiMS\Pdf\Contract;
use Dompdf\Dompdf;

require __DIR__ . '/../vendor/autoload.php';

class MyProvider extends Contract {

    public function setPdf():void
    {
        $this->pdf = new Dompdf();
    }

    public function setContent():void
    {
        $this->pdf->loadHtml('<h1>Hello World!</h1>');
    }
    
    public function download(string $filename):void
    {
        $this->stream($filename, ['Attachment' => true]);
    }
    
    public function stream(?string $filename = null, ?array $options = null):void
    {
        $this->pdf->render();
        $this->pdf->stream(($filename??md5('this') . 'pdf'), ($options??['Attachment' => false]));
        exit;
    }
    
    public function saveToFile(string $filepath, ?Closure $callback = null):void
    {
        $this->pdf->render();
        if ($callback !== null) {
            $callback($this->pdf, $filepath);
        } else {
            file_put_contents($filepath, $this->pdf->output());
            exit;
        }
    }
}

Factory::registerProvider('MyProvider', MyProvider::class);
Factory::useProvider('MyProvider');

if (isset($_GET['download'])) {
    Factory::download('harno.pdf');
}

if (isset($_GET['stream'])) {
    Factory::stream();
}

if (isset($_GET['save'])) {
    // Simple save
    Factory::saveToFile(__DIR__ . '/test.pdf');

    // Advance save with custom file handler
    Factory::saveToFile('test2.pdf', function($pdf, $filepath) {
        // you can use league\filesystem etc.
        file_put_contents(__DIR__ . '/' . $filepath, $pdf->output());
    });
}
```
