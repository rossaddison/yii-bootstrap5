<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5\Tests;

use Yiisoft\Html\Html;
use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yiisoft\Yii\Bootstrap5\Enum\Size;
use Yiisoft\Yii\Bootstrap5\Item;
use Yiisoft\Yii\Bootstrap5\Link;
use Yiisoft\Yii\Bootstrap5\Tabs;
use Yiisoft\Yii\Bootstrap5\TabPane;

final class TabsTest extends TestCase
{
    public function testTabsWoPanes(): void
    {
        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->items(
                    Link::widget()->id('tab-1')->label('Link 1')->url('/link-1'),
                    Link::widget()->id('tab-2')->label('Link 2')->url('/link-2'),
                    Link::widget()->id('tab-3')->label('Link 3')->url('/link-3'),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item"><a id="tab-1" class="nav-link active" href="/link-1" aria-current="page">Link 1</a></li>
        <li class="nav-item"><a id="tab-2" class="nav-link" href="/link-2">Link 2</a></li>
        <li class="nav-item"><a id="tab-3" class="nav-link" href="/link-3">Link 3</a></li>
        </ul>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testSimpleTabs(): void
    {
        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->items(
                    Link::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->content('Pane 1')
                        ),
                    Link::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->content(Html::div('Pane 2'))
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <button type="button" id="tab-2" class="nav-link" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false" data-bs-target="#pane-2">Link 2</button>
        </li>
        </ul>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testActive(): void
    {
        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->activeItem(0)
                ->items(
                    Link::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->content('Pane 1')
                        ),
                    Link::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->content(Html::div('Pane 2'))
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testRenderContent(): void
    {
        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->activeItem(0)
                ->renderContent(false)
                ->items(
                    Link::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->content('Pane 1')
                        ),
                    Link::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->content(Html::div('Pane 2'))
                        ),
                );
        $html = $tabs->render();
        $html .= 'some content here';
        $html .= $tabs->renderTabContent();

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        some content here
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testFade(): void
    {
        $pane = TabPane::widget()->fade(true);

        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->activeItem(0)
                ->renderContent(false)
                ->items(
                    Link::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->tag('a')
                        ->pane(
                            $pane->id('pane-1')
                                 ->content('Pane 1')
                        ),
                    Link::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->tag('a')
                        ->pane(
                            $pane->id('pane-2')
                                 ->content(Html::div('Pane 2'))
                        ),
                );
        $html = $tabs->render();
        $html .= 'some content here';
        $html .= $tabs->renderTabContent();

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        some content here
        <div class="tab-content">
        <div id="pane-1" class="tab-pane fade active show" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane fade" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testPaneOptions(): void
    {
        $pane = TabPane::widget()->fade(true)
                ->options([
                    'class' => 'custom-pane-class',
                ]);

        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->activeItem(0)
                ->renderContent(false)
                ->items(
                    Link::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->tag('a')
                        ->pane(
                            $pane->id('pane-1')
                                 ->content('Pane 1')
                        ),
                    Link::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->content(Html::div('Pane 2'))
                                ->options([
                                    'style' => 'margin: -1px',
                                ])
                        ),
                );
        $html = $tabs->render();
        $html .= 'some content here';
        $html .= $tabs->renderTabContent();

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        some content here
        <div class="tab-content">
        <div id="pane-1" class="custom-pane-class tab-pane fade active show" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane" style="margin: -1px" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, $html);
    }

    public function testContentOptions(): void
    {
        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->activeItem(0)
                ->tabContentOptions([
                    'class' => 'custom-content-class',
                ])
                ->items(
                    Link::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->content('Pane 1')
                        ),
                    Link::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->content(Html::div('Pane 2'))
                        ),
                    Link::widget()
                        ->label('Link 3')
                        ->id('tab-3')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-3')
                                ->content('<span>Pane 3</span>')
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-3" class="nav-link" href="#pane-3" data-bs-toggle="tab" role="tab" aria-controls="pane-3" aria-selected="false">Link 3</a>
        </li>
        </ul>
        <div class="custom-content-class tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        <div id="pane-3" class="tab-pane" tabindex="0" aria-labelledby="tab-3" role="tabpanel">&lt;span&gt;Pane 3&lt;/span&gt;</div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testPaneEncode(): void
    {
        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->items(
                    Link::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->encode(true)
                                ->content('<span>Encoded content</span>')
                        ),
                    Link::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->encode(false)
                                ->content('<span>Not encoded content</span>')
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">&lt;span&gt;Encoded content&lt;/span&gt;</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><span>Not encoded content</span></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testPaneTag(): void
    {
        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->items(
                    Link::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->tag('section')
                                ->encode(true)
                                ->content('<span>Encoded content</span>')
                        ),
                    Link::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->tag('article')
                                ->encode(false)
                                ->content('<span>Not encoded content</span>')
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        <div class="tab-content">
        <section id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">&lt;span&gt;Encoded content&lt;/span&gt;</section>
        <article id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><span>Not encoded content</span></article>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testPills(): void
    {
        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->pills()
                ->items(
                    Link::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->encode(true)
                                ->content('<span>Encoded content</span>')
                        ),
                    Link::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->encode(false)
                                ->content('<span>Not encoded content</span>')
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-pills" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="#pane-1" data-bs-toggle="pill" role="tab" aria-controls="pane-1" aria-selected="true">Link 1</a>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="pill" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </li>
        </ul>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">&lt;span&gt;Encoded content&lt;/span&gt;</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><span>Not encoded content</span></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testMultipleItems(): void
    {
        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->tag('nav')
                ->defaultItem(false)
                ->items(
                    Link::widget()
                           ->label('Link 1')
                           ->id('tab-1')
                           ->pane(
                               TabPane::widget()
                                   ->id('pane-1')
                                   ->encode(true)
                                   ->content('<span>Encoded content</span>')
                           )
                           ->item(
                               Item::widget()->tag('div')
                           ),
                    Link::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->tag('a')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->encode(false)
                                ->content('<span>Not encoded content</span>')
                        )
                );

        $expected = <<<'HTML'
        <nav id="test-tabs" class="nav nav-tabs" role="tablist">
        <div class="nav-item" role="presentation">
        <button type="button" id="tab-1" class="nav-link active" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true" data-bs-target="#pane-1">Link 1</button>
        </div>
        <a id="tab-2" class="nav-link" href="#pane-2" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false">Link 2</a>
        </nav>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">&lt;span&gt;Encoded content&lt;/span&gt;</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><span>Not encoded content</span></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testWoActive(): void
    {
        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->activeItem(null)
                ->items(
                    Link::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->content('Pane 1')
                        ),
                    Link::widget()
                        ->label('Link 2')
                        ->id('tab-2')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-2')
                                ->content(Html::div('Pane 2'))
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <button type="button" id="tab-1" class="nav-link" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="false" data-bs-target="#pane-1">Link 1</button>
        </li>
        <li class="nav-item" role="presentation">
        <button type="button" id="tab-2" class="nav-link" data-bs-toggle="tab" role="tab" aria-controls="pane-2" aria-selected="false" data-bs-target="#pane-2">Link 2</button>
        </li>
        </ul>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Pane 1</div>
        <div id="pane-2" class="tab-pane" tabindex="0" aria-labelledby="tab-2" role="tabpanel"><div>Pane 2</div></div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public static function sizeDataProvider(): array
    {
        return [
            [Size::ExtraSmall, 'flex-column'],
            [Size::Small, 'flex-sm-column'],
            [Size::Medium, 'flex-md-column'],
            [Size::Large, 'flex-lg-column'],
            [Size::ExtraLarge, 'flex-xl-column'],
            [Size::ExtraExtraLarge, 'flex-xxl-column'],
        ];
    }

    /**
     * @dataProvider sizeDataProvider
     */
    public function testVertical(Size $size, string $expected): void
    {
        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->activeItem(null)
                ->vertical($size)
                ->items(
                    Link::widget()
                        ->label('Link 1')
                        ->id('tab-1')
                        ->pane(
                            TabPane::widget()
                                ->id('pane-1')
                                ->content('Pane 1')
                        )
                );

        $this->assertStringContainsString('class="nav nav-tabs ' . $expected . '"', (string)$tabs);
    }

    public function testTabForm(): void
    {
        $tabs = Tabs::widget()
                ->id('test-form')
                ->contentTag('form')
                ->tabContentOptions([
                    'action' => '/',
                ])
                ->items(
                    Link::widget()
                        ->id('')
                        ->label('Step 1')
                        ->pane(
                            TabPane::widget()->tag('fieldset')->id('step-1')->content('Step 1 content'),
                        ),
                    Link::widget()
                        ->id('')
                        ->label('Step 2')
                        ->pane(
                            TabPane::widget()->tag('fieldset')->id('step-2')->content('Step 2 content'),
                        ),
                    Link::widget()->id('')->options(['type' => 'submit'])->label('Submit')->widgetClassName('btn btn-primary')
                );

        $expected = <<<'HTML'
        <ul id="test-form" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <button type="button" id class="nav-link active" data-bs-toggle="tab" role="tab" aria-controls="step-1" aria-selected="true" data-bs-target="#step-1">Step 1</button>
        </li>
        <li class="nav-item" role="presentation">
        <button type="button" id class="nav-link" data-bs-toggle="tab" role="tab" aria-controls="step-2" aria-selected="false" data-bs-target="#step-2">Step 2</button>
        </li>
        <li class="nav-item">
        <button type="submit" id class="btn btn-primary">Submit</button>
        </li>
        </ul>
        <form class="tab-content" action="/">
        <fieldset id="step-1" class="tab-pane active" tabindex="0" role="tabpanel">Step 1 content</fieldset>
        <fieldset id="step-2" class="tab-pane" tabindex="0" role="tabpanel">Step 2 content</fieldset>
        </form>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }

    public function testDropdown(): void
    {
        $tabs = Tabs::widget()
                ->id('test-tabs')
                ->items(
                    Link::widget()
                        ->id('tab-1')
                        ->label('Link 1')
                        ->url('/link-1')
                        ->pane(
                            TabPane::widget()->id('pane-1')->content('Content tab 1'),
                        ),
                    Dropdown::widget()
                        ->id('nested-dropdown')
                        ->toggle(
                            Link::widget()->id('tab-2')->label('Link 2')->url('/link-2')
                        )
                        ->items(
                            Link::widget()->id('')->label('Dropdown link 2')->url('/dropdown/link-1'),
                            Link::widget()->id('')->label('Dropdown link 2')->url('/dropdown/link-2'),
                        ),
                    Link::widget()
                        ->id('tab-3')
                        ->label('Link 3')
                        ->url('/link-3')
                        ->pane(
                            TabPane::widget()->id('pane-3')->content('Content tab 3'),
                        ),
                );

        $expected = <<<'HTML'
        <ul id="test-tabs" class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
        <a id="tab-1" class="nav-link active" href="/link-1" data-bs-toggle="tab" role="tab" aria-controls="pane-1" aria-selected="true" data-bs-target="#pane-1" aria-current="page">Link 1</a>
        </li>
        <li class="dropdown nav-item">
        <a id="tab-2" class="dropdown-toggle nav-link" href="/link-2" aria-expanded="false" role="button" data-bs-toggle="dropdown">Link 2</a>
        <ul id="nested-dropdown" class="dropdown-menu">
        <li><a id class="dropdown-item active" href="/dropdown/link-1" aria-current="page">Dropdown link 2</a></li>
        <li><a id class="dropdown-item" href="/dropdown/link-2">Dropdown link 2</a></li>
        </ul>
        </li>
        <li class="nav-item" role="presentation">
        <a id="tab-3" class="nav-link" href="/link-3" data-bs-toggle="tab" role="tab" aria-controls="pane-3" aria-selected="false" data-bs-target="#pane-3">Link 3</a>
        </li>
        </ul>
        <div class="tab-content">
        <div id="pane-1" class="tab-pane active" tabindex="0" aria-labelledby="tab-1" role="tabpanel">Content tab 1</div>
        <div id="pane-3" class="tab-pane" tabindex="0" aria-labelledby="tab-3" role="tabpanel">Content tab 3</div>
        </div>
        HTML;

        $this->assertEqualsHTML($expected, (string)$tabs);
    }
}
