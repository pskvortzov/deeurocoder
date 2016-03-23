<?php

use Autohelp\Deeurocoder;

class DeeurocoderTest extends PHPUnit_Framework_TestCase
{
    private $deeurocoder;

    function __construct()
    {
        $this->deeurocoder = new Deeurocoder;
    }

    /**
    / @test
    */
    public function it_exists()
    {
        $this->assertInstanceOf('Autohelp\Deeurocoder', $this->deeurocoder);
    }

    /**
    / @test
    */
    public function it_correctly_identifies_basic_eurocodes()
    {

        $this->assertTrue($this->deeurocoder->isEurocode('4005AGN'));
        $this->assertFalse($this->deeurocoder->isEurocode('123'));
        $this->assertTrue($this->deeurocoder->isEurocode('3605BGNC'));
        $this->assertTrue($this->deeurocoder->isEurocode('AM29AGN'));
        $this->assertTrue($this->deeurocoder->isEurocode('ZX11ABL'));
        $this->assertTrue($this->deeurocoder->isEurocode('MAN0ABL'));
        $this->assertTrue($this->deeurocoder->isEurocode('N-IGABL'));
        $this->assertFalse($this->deeurocoder->isEurocode('fakeeurocode'));
        $this->assertTrue($this->deeurocoder->isEurocode('2005AABBLABCDEF2G3A6N1085-KMK qwe'));
        $this->assertTrue($this->deeurocoder->isEurocode('2015DGNBZDEF11101B1C-BEN qw'));
        $this->assertTrue($this->deeurocoder->isEurocode('3005BGNHABC6B3C-BEN qwe'));
        $this->assertTrue($this->deeurocoder->isEurocode('3315ECFHABC6B1Z-KMK qwe'));
        $this->assertFalse($this->deeurocoder->isEurocode('3605B'));
        $this->assertTrue($this->deeurocoder->isEurocode('3005FABH3FVJKT1A6Z-BEN'));
        $this->assertTrue($this->deeurocoder->isEurocode('3005TABL2MDNOP1A1Z-KMK'));
        $this->assertTrue($this->deeurocoder->isEurocode('3006GCAE3GRBDI1A1Z-BEN qwe'));
        $this->assertTrue($this->deeurocoder->isEurocode('3005AKCCLABD1A1F-KMK asd'));
        $this->assertTrue($this->deeurocoder->isEurocode('3005SSBSRQE1G6L-BEN qwe'));
        $this->assertFalse($this->deeurocoder->isEurocode('T-12345 qwe'));
        $this->assertTrue($this->deeurocoder->isEurocode('3006SXCHFVA1C1E-KMK asd'));
        $this->assertTrue($this->deeurocoder->isEurocode('3006AXLVRQC1G1L-BEN qwe'));
    }

    /**
    / @test
    */
    public function it_correctly_identifies_category()
    {
        $this->assertEquals(1, $this->deeurocoder->getCategory('2005AABBLABCDEF2G3A6N1085-KMK qwe'));
        $this->assertEquals(1, $this->deeurocoder->getCategory('2015DGNBZDEF11101B1C-BEN qw'));
        $this->assertEquals(2, $this->deeurocoder->getCategory('3005BGNHABC6B3C-BEN qwe'));
        $this->assertEquals(2, $this->deeurocoder->getCategory('3315ECFHABC6B1Z-KMK qwe'));
        $this->assertEquals(3, $this->deeurocoder->getCategory('3005FABH3FVJKT1A6Z-BEN'));
        $this->assertEquals(3, $this->deeurocoder->getCategory('3005TABL2MDNOP1A1Z-KMK'));
        $this->assertEquals(4, $this->deeurocoder->getCategory('3006GCAE3GRBDI1A1Z-BEN qwe'));
        $this->assertEquals(5, $this->deeurocoder->getCategory('3005AKCCLABD1A1F-KMK asd'));
        $this->assertEquals(5, $this->deeurocoder->getCategory('3005SSBSRQE1G6L-BEN qwe'));
        $this->assertEquals(6, $this->deeurocoder->getCategory('3006SXCHFVA1C1E-KMK asd'));
        $this->assertEquals(6, $this->deeurocoder->getCategory('3006AXLVRQC1G1L-BEN qwe'));
        $this->assertEquals(null, $this->deeurocoder->getCategory('306AXLVRQC1G1L-BEN qwe'));
        $this->assertEquals(null, $this->deeurocoder->getCategory('3067[LVRQC1G1L-BEN qwe'));
        $this->assertEquals(null, $this->deeurocoder->getCategory('3006QXLVRQC1G1L-BEN qwe'));
        $this->assertEquals(null, $this->deeurocoder->getCategory('30068XLVRQC1G1L-BEN qwe'));
    }

    /**
    / @test
    */
    public function it_correctly_parses_brand_and_comment()
    {
        $this->assertEquals('KMK', $this->deeurocoder->getBrand('4437AGSBLV-KMK'));
        $this->assertEquals(null, $this->deeurocoder->getComment('4437AGSBLV-KMK'));

        $this->assertEquals('T', $this->deeurocoder->getBrand('4437ASMRL-T'));
        $this->assertEquals(null, $this->deeurocoder->getComment('4437ASMRL-T'));

        $this->assertEquals('BEN', $this->deeurocoder->getBrand('3003RGNH5FD-BEN'));
        $this->assertEquals(null, $this->deeurocoder->getComment('3003RGNH5FD-BEN'));

        $this->assertEquals(null, $this->deeurocoder->getBrand('4437AGSBL уценка'));
        $this->assertEquals('уценка', $this->deeurocoder->getComment('4437AGSBL уценка'));

        $this->assertEquals('BEN', $this->deeurocoder->getBrand('4437AGSBLHMV1B-BEN уценка'));
        $this->assertEquals('уценка', $this->deeurocoder->getComment('4437AGSBLHMV1B-BEN уценка'));

        $this->assertEquals(null, $this->deeurocoder->getBrand('4437AGS'));
        $this->assertEquals(null, $this->deeurocoder->getComment('4437AGS'));

        $this->assertEquals(null, $this->deeurocoder->getBrand('T-12345 qwe'));
        $this->assertEquals(null, $this->deeurocoder->getComment('T-12345 qwe'));

        $this->assertEquals('BEN', $this->deeurocoder->getBrand('N-IGAGSBLHMV1B2J3I-BEN уценка'));
        $this->assertEquals('уценка', $this->deeurocoder->getComment('N-IGAGSBLHMV1B2J3I-BEN уценка'));
    }

    /**
    / @test
    */
    public function it_correctly_parses_manufacturer_and_model()
    {

        $this->assertEquals(['CHEVROLET'], $this->deeurocoder->getManufacturer('3003RGNH5FD-BEN'));
        $this->assertEquals(null, $this->deeurocoder->getManufacturer('T-12345 qwe'));
        $this->assertEquals(null, $this->deeurocoder->getModel('T-12345 qwe'));
        $this->assertEquals(['ASTON MARTIN'], $this->deeurocoder->getManufacturer('2111ABL'));
        $this->assertEquals(['PRELUDE  87-92', 'PRELUDE  90-92'], $this->deeurocoder->getModel('3931ABL'));
        $this->assertEquals(['NISSAN'], $this->deeurocoder->getManufacturer('N-IGAGSBLHMV1B2J3I-BEN уценка'));
        $this->assertEquals(['ALMERA 4D G15 13-'], $this->deeurocoder->getModel('N-IGAGSBLHMV1B2J3I-BEN уценка'));
        $this->assertEquals(['UNKNOWN'], $this->deeurocoder->getManufacturer('3623AGN'));
        $this->assertEquals(['UNKNOWN'], $this->deeurocoder->getModel('3623AGN'));
    }

    /**
    / @test
    */
    public function it_correctly_parses_windshield_parts()
    {
        $this->assertEquals(['A'], array_keys($this->deeurocoder->getGlassType('4437AGN')));
        $this->assertEquals(['GN'], array_keys($this->deeurocoder->getGlassTint('4437AGN')));
        $this->assertEquals([], array_keys($this->deeurocoder->getTopTint('4437AGN')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437AGN')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437AGN')));

        $this->assertEquals(['A'], array_keys($this->deeurocoder->getGlassType('4437AGNA')));
        $this->assertEquals(['GN'], array_keys($this->deeurocoder->getGlassTint('4437AGNA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getTopTint('4437AGNA')));
        $this->assertEquals(['A'], array_keys($this->deeurocoder->getCharacteristics('4437AGNA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437AGNA')));

        $this->assertEquals(['A'], array_keys($this->deeurocoder->getGlassType('4437AGN3C')));
        $this->assertEquals(['GN'], array_keys($this->deeurocoder->getGlassTint('4437AGN3C')));
        $this->assertEquals([], array_keys($this->deeurocoder->getTopTint('4437AGN3C')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437AGN3C')));
        $this->assertEquals(['3C'], array_keys($this->deeurocoder->getModifications('4437AGN3C')));

        $this->assertEquals(['A'], array_keys($this->deeurocoder->getGlassType('4437AGNABC')));
        $this->assertEquals(['GN'], array_keys($this->deeurocoder->getGlassTint('4437AGNABC')));
        $this->assertEquals([], array_keys($this->deeurocoder->getTopTint('4437AGNABC')));
        $this->assertEquals(['A', 'B', 'C'], array_keys($this->deeurocoder->getCharacteristics('4437AGNABC')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437AGNABC')));

        $this->assertEquals(['A'], array_keys($this->deeurocoder->getGlassType('4437AGN4C5025')));
        $this->assertEquals(['GN'], array_keys($this->deeurocoder->getGlassTint('4437AGN4C5025')));
        $this->assertEquals([], array_keys($this->deeurocoder->getTopTint('4437AGN4C5025')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437AGN4C5025')));
        $this->assertEquals(['4C', '50', '25'], array_keys($this->deeurocoder->getModifications('4437AGN4C5025')));

        $this->assertEquals(['A'], array_keys($this->deeurocoder->getGlassType('4437ABLORZ1H3859')));
        $this->assertEquals(['BL'], array_keys($this->deeurocoder->getGlassTint('4437ABLORZ1H3859')));
        $this->assertEquals([], array_keys($this->deeurocoder->getTopTint('4437ABLORZ1H3859')));
        $this->assertEquals(['O', 'R', 'Z'], array_keys($this->deeurocoder->getCharacteristics('4437ABLORZ1H3859')));
        $this->assertEquals(['1H', '38', '59'], array_keys($this->deeurocoder->getModifications('4437ABLORZ1H3859')));

        $this->assertEquals(['A'], array_keys($this->deeurocoder->getGlassType('4437ABLBLORZ1H3055')));
        $this->assertEquals(['BL'], array_keys($this->deeurocoder->getGlassTint('4437ABLBLORZ1H3055')));
        $this->assertEquals(['BL'], array_keys($this->deeurocoder->getTopTint('4437ABLBLORZ1H3055')));
        $this->assertEquals(['O', 'R', 'Z'], array_keys($this->deeurocoder->getCharacteristics('4437ABLBLORZ1H3055')));
        $this->assertEquals(['1H', '30', '55'], array_keys($this->deeurocoder->getModifications('4437ABLBLORZ1H3055')));

        $this->assertEquals(['A'], array_keys($this->deeurocoder->getGlassType('4437AGNBZHPR6I4075')));
        $this->assertEquals(['GN'], array_keys($this->deeurocoder->getGlassTint('4437AGNBZHPR6I4075')));
        $this->assertEquals(['BZ'], array_keys($this->deeurocoder->getTopTint('4437AGNBZHPR6I4075')));
        $this->assertEquals(['H', 'P', 'R'], array_keys($this->deeurocoder->getCharacteristics('4437AGNBZHPR6I4075')));
        $this->assertEquals(['6I', '40', '75'], array_keys($this->deeurocoder->getModifications('4437AGNBZHPR6I4075')));

        $this->assertEquals(['A'], array_keys($this->deeurocoder->getGlassType('4437AYDHPR6I4075')));
        $this->assertEquals([], array_keys($this->deeurocoder->getGlassTint('4437AYDHPR6I4075')));
        $this->assertEquals([], array_keys($this->deeurocoder->getTopTint('4437AYDHPR6I4075')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437AYDHPR6I4075')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437AYDHPR6I4075')));
        $this->assertFalse($this->deeurocoder->isEurocode('4437AYDHPR6I4075'));
    }

    /**
    / @test
    */
    public function it_correctly_parses_rear_glass_parts()
    {
        $this->assertEquals(['B'], array_keys($this->deeurocoder->getGlassType('4437BGN')));
        $this->assertEquals(['GN'], array_keys($this->deeurocoder->getGlassTint('4437BGN')));
        $this->assertEquals([], array_keys($this->deeurocoder->getBodyType('4437BGN')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437BGN')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437BGN')));
        $this->assertFalse($this->deeurocoder->isEurocode('4437BGN'));

        $this->assertEquals(['B'], array_keys($this->deeurocoder->getGlassType('4437BGNH')));
        $this->assertEquals(['GN'], array_keys($this->deeurocoder->getGlassTint('4437BGNH')));
        $this->assertEquals(['H'], array_keys($this->deeurocoder->getBodyType('4437BGNH')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437BGNH')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437BGNH')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437BGNH'));

        $this->assertEquals(['E'], array_keys($this->deeurocoder->getGlassType('4437EBLCC')));
        $this->assertEquals(['BL'], array_keys($this->deeurocoder->getGlassTint('4437EBLCC')));
        $this->assertEquals(['C'], array_keys($this->deeurocoder->getBodyType('4437EBLCC')));
        $this->assertEquals(['C'], array_keys($this->deeurocoder->getCharacteristics('4437EBLCC')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437EBLCC')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437EBLCC'));

        $this->assertEquals(['E'], array_keys($this->deeurocoder->getGlassType('4437EBLL1A')));
        $this->assertEquals(['BL'], array_keys($this->deeurocoder->getGlassTint('4437EBLL1A')));
        $this->assertEquals(['L'], array_keys($this->deeurocoder->getBodyType('4437EBLL1A')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437EBLL1A')));
        $this->assertEquals(['1A'], array_keys($this->deeurocoder->getModifications('4437EBLL1A')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437EBLL1A'));

        $this->assertEquals(['B'], array_keys($this->deeurocoder->getGlassType('4437BGNVDF1A3C')));
        $this->assertEquals(['GN'], array_keys($this->deeurocoder->getGlassTint('4437BGNVDF1A3C')));
        $this->assertEquals(['V'], array_keys($this->deeurocoder->getBodyType('4437BGNVDF1A3C')));
        $this->assertEquals(['D', 'F'], array_keys($this->deeurocoder->getCharacteristics('4437BGNVDF1A3C')));
        $this->assertEquals(['1A', '3C'], array_keys($this->deeurocoder->getModifications('4437BGNVDF1A3C')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437BGNVDF1A3C'));
    }

    /**
    / @test
    */
    public function it_correctly_parses_bodyglass_parts()
    {
        $this->assertEquals(['F'], array_keys($this->deeurocoder->getGlassType('4437FAB')));
        $this->assertEquals(['AB'], array_keys($this->deeurocoder->getGlassTint('4437FAB')));
        $this->assertEquals([], array_keys($this->deeurocoder->getBodyType('4437FAB')));
        $this->assertEquals([], array_keys($this->deeurocoder->getGlassPosition('4437FAB')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437FAB')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437FAB')));
        $this->assertFalse($this->deeurocoder->isEurocode('4437FAB'));

        $this->assertEquals(['H'], array_keys($this->deeurocoder->getGlassType('4437HCDH5')));
        $this->assertEquals(['CD'], array_keys($this->deeurocoder->getGlassTint('4437HCDH5')));
        $this->assertEquals(['H5'], array_keys($this->deeurocoder->getBodyType('4437HCDH5')));
        $this->assertEquals([], array_keys($this->deeurocoder->getGlassPosition('4437HCDH5')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437HCDH5')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437HCDH5')));
        $this->assertFalse($this->deeurocoder->isEurocode('4437HCDH5'));

        $this->assertEquals(['L'], array_keys($this->deeurocoder->getGlassType('4437LGDL4MD')));
        $this->assertEquals(['GD'], array_keys($this->deeurocoder->getGlassTint('4437LGDL4MD')));
        $this->assertEquals(['L4'], array_keys($this->deeurocoder->getBodyType('4437LGDL4MD')));
        $this->assertEquals(['MD'], array_keys($this->deeurocoder->getGlassPosition('4437LGDL4MD')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437LGDL4MD')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437LGDL4MD')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437LGDL4MD'));

        $this->assertEquals(['R'], array_keys($this->deeurocoder->getGlassType('4437RGDP4MQD')));
        $this->assertEquals(['GD'], array_keys($this->deeurocoder->getGlassTint('4437RGDP4MQD')));
        $this->assertEquals(['P4'], array_keys($this->deeurocoder->getBodyType('4437RGDP4MQD')));
        $this->assertEquals(['MQ'], array_keys($this->deeurocoder->getGlassPosition('4437RGDP4MQD')));
        $this->assertEquals(['D'], array_keys($this->deeurocoder->getCharacteristics('4437RGDP4MQD')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437RGDP4MQD')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437RGDP4MQD'));

        $this->assertEquals(['R'], array_keys($this->deeurocoder->getGlassType('4437RGDP4MQ3C')));
        $this->assertEquals(['GD'], array_keys($this->deeurocoder->getGlassTint('4437RGDP4MQ3C')));
        $this->assertEquals(['P4'], array_keys($this->deeurocoder->getBodyType('4437RGDP4MQ3C')));
        $this->assertEquals(['MQ'], array_keys($this->deeurocoder->getGlassPosition('4437RGDP4MQ3C')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437RGDP4MQ3C')));
        $this->assertEquals(['3C'], array_keys($this->deeurocoder->getModifications('4437RGDP4MQ3C')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437RGDP4MQ3C'));

        $this->assertEquals(['T'], array_keys($this->deeurocoder->getGlassType('4437TBLS2MQFI3C6Z')));
        $this->assertEquals(['BL'], array_keys($this->deeurocoder->getGlassTint('4437TBLS2MQFI3C6Z')));
        $this->assertEquals(['S2'], array_keys($this->deeurocoder->getBodyType('4437TBLS2MQFI3C6Z')));
        $this->assertEquals(['MQ'], array_keys($this->deeurocoder->getGlassPosition('4437TBLS2MQFI3C6Z')));
        $this->assertEquals(['F', 'I'], array_keys($this->deeurocoder->getCharacteristics('4437TBLS2MQFI3C6Z')));
        $this->assertEquals(['3C', '6Z'], array_keys($this->deeurocoder->getModifications('4437TBLS2MQFI3C6Z')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437TBLS2MQFI3C6Z'));
    }

    /**
    / @test
    */
    public function it_correctly_parses_glass_roof_parts()
    {
        $this->assertEquals(['G'], array_keys($this->deeurocoder->getGlassType('4437GBA')));
        $this->assertEquals(['BA'], array_keys($this->deeurocoder->getGlassTint('4437GBA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getBodyType('4437GBA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getGlassPosition('4437GBA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437GBA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437GBA')));
        $this->assertFalse($this->deeurocoder->isEurocode('4437GBA'));

        $this->assertEquals(['G'], array_keys($this->deeurocoder->getGlassType('4437GBAH3')));
        $this->assertEquals(['BA'], array_keys($this->deeurocoder->getGlassTint('4437GBAH3')));
        $this->assertEquals(['H3'], array_keys($this->deeurocoder->getBodyType('4437GBAH3')));
        $this->assertEquals([], array_keys($this->deeurocoder->getGlassPosition('4437GBAH3')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437GBAH3')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437GBAH3')));
        $this->assertFalse($this->deeurocoder->isEurocode('4437GBAH3'));

        $this->assertEquals(['G'], array_keys($this->deeurocoder->getGlassType('4437GBAH3GR')));
        $this->assertEquals(['BA'], array_keys($this->deeurocoder->getGlassTint('4437GBAH3GR')));
        $this->assertEquals(['H3'], array_keys($this->deeurocoder->getBodyType('4437GBAH3GR')));
        $this->assertEquals(['GR'], array_keys($this->deeurocoder->getGlassPosition('4437GBAH3GR')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437GBAH3GR')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437GBAH3GR')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437GBAH3GR'));

        $this->assertEquals(['G'], array_keys($this->deeurocoder->getGlassType('4437GBAH3GRRS')));
        $this->assertEquals(['BA'], array_keys($this->deeurocoder->getGlassTint('4437GBAH3GRRS')));
        $this->assertEquals(['H3'], array_keys($this->deeurocoder->getBodyType('4437GBAH3GRRS')));
        $this->assertEquals(['GR'], array_keys($this->deeurocoder->getGlassPosition('4437GBAH3GRRS')));
        $this->assertEquals(['R', 'S'], array_keys($this->deeurocoder->getCharacteristics('4437GBAH3GRRS')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437GBAH3GRRS')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437GBAH3GRRS'));

        $this->assertEquals(['G'], array_keys($this->deeurocoder->getGlassType('4437GBAH3GR1A')));
        $this->assertEquals(['BA'], array_keys($this->deeurocoder->getGlassTint('4437GBAH3GR1A')));
        $this->assertEquals(['H3'], array_keys($this->deeurocoder->getBodyType('4437GBAH3GR1A')));
        $this->assertEquals(['GR'], array_keys($this->deeurocoder->getGlassPosition('4437GBAH3GR1A')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437GBAH3GR1A')));
        $this->assertEquals(['1A'], array_keys($this->deeurocoder->getModifications('4437GBAH3GR1A')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437GBAH3GR1A'));

        $this->assertEquals(['G'], array_keys($this->deeurocoder->getGlassType('4437GBAH3GRIN1A6Z')));
        $this->assertEquals(['BA'], array_keys($this->deeurocoder->getGlassTint('4437GBAH3GRIN1A6Z')));
        $this->assertEquals(['H3'], array_keys($this->deeurocoder->getBodyType('4437GBAH3GRIN1A6Z')));
        $this->assertEquals(['GR'], array_keys($this->deeurocoder->getGlassPosition('4437GBAH3GRIN1A6Z')));
        $this->assertEquals(['I', 'N'], array_keys($this->deeurocoder->getCharacteristics('4437GBAH3GRIN1A6Z')));
        $this->assertEquals(['1A', '6Z'], array_keys($this->deeurocoder->getModifications('4437GBAH3GRIN1A6Z')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437GBAH3GRIN1A6Z'));
    }

    /**
    / @test
    */
    public function it_correctly_parses_sk_accessories_parts()
    {
        $this->assertEquals(['A'], array_keys($this->deeurocoder->getGlassType('4437AKA')));
        $this->assertEquals(['K'], array_keys($this->deeurocoder->getGlassAccessories('4437AKA')));
        $this->assertEquals(['A'], array_keys($this->deeurocoder->getAccessoryType('4437AKA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getBodyType('4437AKA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getGlassPosition('4437AKA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437AKA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437AKA')));
        $this->assertFalse($this->deeurocoder->isEurocode('4437AKA'));

        $this->assertEquals(['S'], array_keys($this->deeurocoder->getGlassType('4437SSSH')));
        $this->assertEquals(['S'], array_keys($this->deeurocoder->getGlassAccessories('4437SSSH')));
        $this->assertEquals(['S'], array_keys($this->deeurocoder->getAccessoryType('4437SSSH')));
        $this->assertEquals(['H'], array_keys($this->deeurocoder->getBodyType('4437SSSH')));
        $this->assertEquals([], array_keys($this->deeurocoder->getGlassPosition('4437SSSH')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437SSSH')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437SSSH')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437SSSH'));

        $this->assertEquals(['S'], array_keys($this->deeurocoder->getGlassType('4437SSSSSS')));
        $this->assertEquals(['S'], array_keys($this->deeurocoder->getGlassAccessories('4437SSSSSS')));
        $this->assertEquals(['S'], array_keys($this->deeurocoder->getAccessoryType('4437SSSSSS')));
        $this->assertEquals(['S'], array_keys($this->deeurocoder->getBodyType('4437SSSSSS')));
        $this->assertEquals(['SS'], array_keys($this->deeurocoder->getGlassPosition('4437SSSSSS')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437SSSSSS')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437SSSSSS')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437SSSSSS'));

        $this->assertEquals(['G'], array_keys($this->deeurocoder->getGlassType('4437GKIRLAF')));
        $this->assertEquals(['K'], array_keys($this->deeurocoder->getGlassAccessories('4437GKIRLAF')));
        $this->assertEquals(['I'], array_keys($this->deeurocoder->getAccessoryType('4437GKIRLAF')));
        $this->assertEquals(['R'], array_keys($this->deeurocoder->getBodyType('4437GKIRLAF')));
        $this->assertEquals(['LA'], array_keys($this->deeurocoder->getGlassPosition('4437GKIRLAF')));
        $this->assertEquals(['F'], array_keys($this->deeurocoder->getCharacteristics('4437GKIRLAF')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437GKIRLAF')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437GKIRLAF'));

        $this->assertEquals(['R'], array_keys($this->deeurocoder->getGlassType('4437RSATGP6C')));
        $this->assertEquals(['S'], array_keys($this->deeurocoder->getGlassAccessories('4437RSATGP6C')));
        $this->assertEquals(['A'], array_keys($this->deeurocoder->getAccessoryType('4437RSATGP6C')));
        $this->assertEquals(['T'], array_keys($this->deeurocoder->getBodyType('4437RSATGP6C')));
        $this->assertEquals(['GP'], array_keys($this->deeurocoder->getGlassPosition('4437RSATGP6C')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437RSATGP6C')));
        $this->assertEquals(['6C'], array_keys($this->deeurocoder->getModifications('4437RSATGP6C')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437RSATGP6C'));

        $this->assertEquals(['C'], array_keys($this->deeurocoder->getGlassType('4437CSWVSSWVU3D5Z')));
        $this->assertEquals(['S'], array_keys($this->deeurocoder->getGlassAccessories('4437CSWVSSWVU3D5Z')));
        $this->assertEquals(['W'], array_keys($this->deeurocoder->getAccessoryType('4437CSWVSSWVU3D5Z')));
        $this->assertEquals(['V'], array_keys($this->deeurocoder->getBodyType('4437CSWVSSWVU3D5Z')));
        $this->assertEquals(['SS'], array_keys($this->deeurocoder->getGlassPosition('4437CSWVSSWVU3D5Z')));
        $this->assertEquals(['W', 'V', 'U'], array_keys($this->deeurocoder->getCharacteristics('4437CSWVSSWVU3D5Z')));
        $this->assertEquals(['3D', '5Z'], array_keys($this->deeurocoder->getModifications('4437CSWVSSWVU3D5Z')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437CSWVSSWVU3D5Z'));
    }

    /**
    / @test
    */
    public function it_correctly_parses_x_accessories_parts()
    {
        $this->assertEquals(['A'], array_keys($this->deeurocoder->getGlassType('4437AXA')));
        $this->assertEquals(['X'], array_keys($this->deeurocoder->getGlassAccessories('4437AXA')));
        $this->assertEquals(['A'], array_keys($this->deeurocoder->getAccessoryType('4437AXA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getBodyType('4437AXA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getGlassPosition('4437AXA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437AXA')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437AXA')));
        $this->assertFalse($this->deeurocoder->isEurocode('4437AXA'));

        $this->assertEquals(['C'], array_keys($this->deeurocoder->getGlassType('4437CXBS')));
        $this->assertEquals(['X'], array_keys($this->deeurocoder->getGlassAccessories('4437CXBS')));
        $this->assertEquals(['B'], array_keys($this->deeurocoder->getAccessoryType('4437CXBS')));
        $this->assertEquals(['S'], array_keys($this->deeurocoder->getBodyType('4437CXBS')));
        $this->assertEquals([], array_keys($this->deeurocoder->getGlassPosition('4437CXBS')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437CXBS')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437CXBS')));
        $this->assertFalse($this->deeurocoder->isEurocode('4437CXBS'));

        $this->assertEquals(['R'], array_keys($this->deeurocoder->getGlassType('4437RXEVLR')));
        $this->assertEquals(['X'], array_keys($this->deeurocoder->getGlassAccessories('4437RXEVLR')));
        $this->assertEquals(['E'], array_keys($this->deeurocoder->getAccessoryType('4437RXEVLR')));
        $this->assertEquals(['V'], array_keys($this->deeurocoder->getBodyType('4437RXEVLR')));
        $this->assertEquals(['LR'], array_keys($this->deeurocoder->getGlassPosition('4437RXEVLR')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437RXEVLR')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437RXEVLR')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437RXEVLR'));

        $this->assertEquals(['G'], array_keys($this->deeurocoder->getGlassType('4437GXGMRDL')));
        $this->assertEquals(['X'], array_keys($this->deeurocoder->getGlassAccessories('4437GXGMRDL')));
        $this->assertEquals(['G'], array_keys($this->deeurocoder->getAccessoryType('4437GXGMRDL')));
        $this->assertEquals(['M'], array_keys($this->deeurocoder->getBodyType('4437GXGMRDL')));
        $this->assertEquals(['RD'], array_keys($this->deeurocoder->getGlassPosition('4437GXGMRDL')));
        $this->assertEquals(['L'], array_keys($this->deeurocoder->getCharacteristics('4437GXGMRDL')));
        $this->assertEquals([], array_keys($this->deeurocoder->getModifications('4437GXGMRDL')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437GXGMRDL'));

        $this->assertEquals(['R'], array_keys($this->deeurocoder->getGlassType('4437RXFTPR8K')));
        $this->assertEquals(['X'], array_keys($this->deeurocoder->getGlassAccessories('4437RXFTPR8K')));
        $this->assertEquals(['F'], array_keys($this->deeurocoder->getAccessoryType('4437RXFTPR8K')));
        $this->assertEquals(['T'], array_keys($this->deeurocoder->getBodyType('4437RXFTPR8K')));
        $this->assertEquals(['PR'], array_keys($this->deeurocoder->getGlassPosition('4437RXFTPR8K')));
        $this->assertEquals([], array_keys($this->deeurocoder->getCharacteristics('4437RXFTPR8K')));
        $this->assertEquals(['8K'], array_keys($this->deeurocoder->getModifications('4437RXFTPR8K')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437RXFTPR8K'));

        $this->assertEquals(['F'], array_keys($this->deeurocoder->getGlassType('4437FXACFVMWY2G3L')));
        $this->assertEquals(['X'], array_keys($this->deeurocoder->getGlassAccessories('4437FXACFVMWY2G3L')));
        $this->assertEquals(['A'], array_keys($this->deeurocoder->getAccessoryType('4437FXACFVMWY2G3L')));
        $this->assertEquals(['C'], array_keys($this->deeurocoder->getBodyType('4437FXACFVMWY2G3L')));
        $this->assertEquals(['FV'], array_keys($this->deeurocoder->getGlassPosition('4437FXACFVMWY2G3L')));
        $this->assertEquals(['M', 'W', 'Y'], array_keys($this->deeurocoder->getCharacteristics('4437FXACFVMWY2G3L')));
        $this->assertEquals(['2G', '3L'], array_keys($this->deeurocoder->getModifications('4437FXACFVMWY2G3L')));
        $this->assertTrue($this->deeurocoder->isEurocode('4437FXACFVMWY2G3L'));
    }

}
