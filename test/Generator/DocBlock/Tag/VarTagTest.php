<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Code\Generator\DocBlock\Tag;

use PHPUnit\Framework\TestCase;
use Zend\Code\Generator\DocBlock\Tag\VarTag;
use Zend\Code\Generator\DocBlock\TagManager;
use Zend\Code\Reflection\DocBlock\Tag\VarTag as ReflectionVarTag;
use Zend\Code\Reflection\DocBlockReflection;

/**
 * @covers \Zend\Code\Generator\DocBlock\Tag\VarTag
 */
class VarTagTest extends TestCase
{
    /**
     * @var VarTag
     */
    private $tag;

    /**
     * @var TagManager
     */
    private $tagManager;

    protected function setUp() : void
    {
        parent::setUp();

        $this->tag        = new VarTag();
        $this->tagManager = new TagManager();

        $this->tagManager->initializeDefaultTags();
    }

    public function testGetterAndSetterPersistValue() : void
    {
        $tag = new VarTag('variable');

        self::assertSame('variable', $tag->getVariableName());
    }

    public function testGetterForVariableNameTrimsCorrectly() : void
    {
        $this->tag->setVariableName('$variable$');
        $this->assertEquals('variable$', $this->tag->getVariableName());
    }

    public function testNameIsCorrect() : void
    {
        $this->assertEquals('var', $this->tag->getName());
    }

    public function testParamProducesCorrectDocBlockLine() : void
    {
        $this->tag->setVariableName('variable');
        $this->tag->setTypes('string[]');
        $this->tag->setDescription('description');
        $this->assertEquals('@var string[] $variable description', $this->tag->generate());
    }

    public function testConstructorWithOptions() : void
    {
        $this->tag->setOptions([
            'variableName' => 'foo',
            'types'        => ['string'],
            'description'  => 'description',
        ]);
        $tagWithOptionsFromConstructor = new VarTag('foo', ['string'], 'description');
        $this->assertEquals($this->tag->generate(), $tagWithOptionsFromConstructor->generate());
    }

    public function testCreatingTagFromReflection() : void
    {
        $reflectionTag = (new DocBlockReflection('/** @var int $foo description'))
            ->getTag('var');

        self::assertInstanceOf(ReflectionVarTag::class, $reflectionTag);

        /** @var VarTag $tag */
        $tag = $this->tagManager->createTagFromReflection($reflectionTag);

        $this->assertInstanceOf(VarTag::class, $tag);
        $this->assertEquals('foo', $tag->getVariableName());
        $this->assertEquals('description', $tag->getDescription());
        $this->assertEquals('int', $tag->getTypesAsString());
    }
}
