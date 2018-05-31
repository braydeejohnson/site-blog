#Lets build an Uno API (Part Uno)
---
![uno](https://upload.wikimedia.org/wikipedia/commons/thumb/2/28/Baraja_de_UNO.JPG/319px-Baraja_de_UNO.JPG)

How often when you're thinking about making your next side project does your mind immediately go to "Uno"? Yea me either. But mine did...

##Why?

I remember the day I was on my way home from work, thinking about a bunch of software development methodologies and was thinking how I could test some of them out to better understand them. I started thinking about several patterns and how they apply differently for different scenarios, and I started to take my mind down things not normally in the web development space. Chess, Blackjack, Tic-Tac-Toe, Uno! Writing any of these has fairly simple business/game rules, and can be expressed very quickly, and in our case, googled for a list of rules. 

**Rules courtesy of [unorules.com][rules]**
[rules]: https://unorules.com
>Game Play: The first player is normally the player to the left of the dealer (you can also choose the youngest player) and gameplay usually follows a clockwise direction. Every player views his/her cards and tries to match the card in the Discard Pile.

##Outline

Our main focus in these first few parts is to start laying out the foundation of the project. 
* Use the Laravel framework, version 5.6 just released at the time of writing this 
* Setup our initial code to represent the game's rules and objects
* Begin writing tests around the rules of the game to test our logic


##Install

Lets begin by setting up our environment, we'll use the latest version of [Laravel](https://laravel.com) and get our project started. Installation is easy if you follow the steps outline in their [docs](https://laravel.com/docs/5.6/installation).

I prefer to use the create-project method via Composer:

```bash
composer create-project --prefer-dist laravel/laravel uno
```

Enter the new project and serve the project to be accessed via web

```bash
cd uno
php artisan serve --port=8080
```

Navigate to http://localhost:8080

![Laravel is up and running](/img/laravel-base-up.png)

In just a few easy steps, we've got our framework installed and updated, and the application being served thanks to PHP and Laravel.

##Setup

Let's layout the rules for Uno in their simplest forms:

1. Uno consists of 108 cards, 25 of each of the 4 colors:
  1. Red Cards
  1. Blue Cards
  1. Green Cards
  1. Yellow Cards
1. Each color will have 2 of each rank except zero. 
1. The rank cards are:
  1. 0-9 
  1. Skip
  1. Draw Two
  1. Reverse
1. The deck will also contain 4:
  1. Wild Cards
  1. Wild Draw 4 Cards
  
Each player starts by drawing 7 cards face down. The rest of the cards are called a Draw Pile.
Cards will be played into a Discard Pile, separate from the Draw Pile. The game begins by drawing a Card from the top of the Draw Pile and Moving it to the top the discard pile.

Now that we understand the basics, let's build out the Card class that will make up the details of an Uno Card. 

Create the file `app\Game\Card.php`
```php
<?php

namespace App\Game;

class Card
{
	/** Card Color Constants */
	const RED_CARD = 'red';
	const BLUE_CARD = 'blue';
	const GREEN_CARD = 'green';
	const YELLOW_CARD = 'yellow';

	/** Card Type Constants */
	const NUMERIC_CARD = 'numeric';
	const SKIP_CARD = 'skip';
	const DRAW_CARD = 'draw';
	const REVERSE_CARD = 'reverse';
}
```

Our Card class contains the constants to help us define the card colors and the card types. Next let's add some state management to the Card class so we can retain some information about a Card instance.

```php
	protected $id;
    protected $type;
    protected $color = null;
    protected $value = null;
    protected $playable = false;
```

First, we have an identifier for the card, this will come in use a bit later. Next is the type of card, followed by the color of the card. We *null* the default color because our wild card don't always have a color defined, that happens upon an action. The value is *null* because it only applies to numeric cards. Finally the playable boolean defaults to *false* until the game validates if that card may be played against the current card in play on the Discard Pile.

Next let's define our constructor to allow us to create cards and define its state. We'll also add some accessors to our protected properties

```php
	/**
	 * Card constructor.
	 * 
	 * @param $id
	 * @param $type
	 * @param null $color
	 * @param null $value
	 */
	public function __construct($id, $type, $color = null, $value = null){
		$this->id = $id;
		$this->type = $type;
		$this->color = $color;
		$this->value = $value;
	}

	/**
	 * Return the Card's ID
	 *
	 * @return string
	 */
	public function id(){
		return $this->id;
	}

	/**
	 * Return the Card's Type
	 *
	 * @return string
	 */
	public function type(){
		return $this->type;
	}

	/**
	 * Return the Card's Color
	 *
	 * @return null|string
	 */
	public function color(){
		return $this->color;
	}

	/**
	 * Return the Card's Value
	 *
	 * @return null|integer
	 */
	public function value(){
		if($this->type === static::NUMERIC){
			return $this->value;
		}

		return null;
	}
```

Now that we have our Card class put together and a way to define individual cards, we'll be creating the Uno class which will be responsible for managing the game's rules and the process for setting up the Game's state.

Create the file `app\Game\Uno.php`
```php
<?php

namespace App\Game;

class Uno
{
	const DECK_CARD_COUNT = 108;
	const CARD_COLORS = [
		Card::RED,
		Card::BLUE,
		Card::GREEN,
		Card::YELLOW
	];

	/** @var Collection $drawPile */
	protected $drawPile;

	/** @var Collection $discardPile */
	protected $discardPile;
}
```

We've defined the constants for the number of cards a deck contains. Also we've set the Card colors as a list. Next we set the drawPile and discardPile as Collection properties. This will make card manipulation convenient later.

Next we add the functions for initializing our Game state.

```php
	/**
	 * @return Collection
	 */
	public function drawPile(){
		return $this->drawPile;
	}

	/**
	 * Creates a new game of Uno
	 *
	 * @return static
	 */
	public static function newGame(){
		$uno = new static;
		$uno->setupDrawPile();
		$uno->shuffleDrawPile();

		return $uno;
	}

	/**
	 * Setup a new Draw Pile
	 */
	public function setupDrawPile(){
		$this->drawPile = collect([]);
		//Create 25 cards for each color
		foreach(self::CARD_COLORS as $color){
			//Create 0-9 Numeric Cards
			for($i = 0; $i <= 9; $i++){
				$this->addCard(($i === 0) ? 1 : 2, Card::NUMERIC, $color, $i);
			}

			//Create Skip Cards
			$this->addCard(2, Card::SKIP, $color);

			//Create Draw Two Cards
			$this->addCard(2, Card::DRAW, $color);

			//Create Reverse Cards
			$this->addCard(2, Card::REVERSE, $color);
		}

		//Create Wild Cards
		$this->addCard(4, Card::WILD);

		//Create Wild Draw Four Cards
		$this->addCard(4, Card::WILD_DRAW);
	}

	/**
	 * Shuffles the Draw Pile
	 */
	public function shuffleDrawPile(){
		$this->drawPile = $this->drawPile->shuffle();
	}

	/**
	 * Add a Card to the deck duplicated by quantity
	 *
	 * @param $quantity
	 * @param $type
	 * @param null $color
	 * @param null $value
	 */
	private function addCard($quantity, $type, $color = null, $value = null){
		for($i = 0; $i < $quantity; $i++){
			$this->drawPile->push(new Card(Uuid::uuid4(), $type, $color, $value));
		}
	}
```

Ok, so the drawPile function returns the drawPile - simple. 

The newGame function is a named constructor for setting up a new game of uno, by setting up the draw pile with the correct cards and then shuffling the deck. It'll make it easy to create a new game with the simple syntax of `Uno::newGame();`

SetupDrawPile is a bit more involved. This function initializes the draw pile as a Collection, then begins following the card count rule for each color. 25 of each color card is created and added to the drawPile by using the addCard method. After each of the colors is done, we add the remaining 4 wilds and 4 wild draw four cards. 

Looking at the shuffleDrawPile, it simply shuffles the collection object and updates itself. 

Finally the addCard function loops the quantity of a card and pushes the newly created Cards onto the drawPile stack.

###Verify

Now that we've created the classes and methods needed to start our first Uno game, let's be "good" developers and write some tests to verify we've got everything working so far.

`php artisan make:test UnoTest --unit`

Modify the *UnoTest.php* in the tests/Unit folder to add some tests surrounding the Uno Game we've created thus far. We want to make sure we cover all of the basic rules.

1. Card Count is 108
1. Each Color has 25 Cards
1. There are 4 of each type of Wild Cards
1. There are 8 of each type of Action Cards
1. There are all 0-9 Numeric Cards for each Color

```php
<?php

namespace Tests\Unit;

use App\Game\Uno;
use Tests\TestCase;

class UnoTest extends TestCase
{
	/** @var Uno */
    protected $game;

    public function setUp(){
        parent::setup();

        $this->game = Uno::newGame();
    }

    /**
     * Test Uno Game has all Cards by Count
     */
    public function testUnoHasAllCardsCount()
    {
        $this->assertTrue($this->game->drawPile()->count() === Uno::DECK_CARD_COUNT);
    }

    /**
     * Test Uno has 25 Cards for each Color
     */
    public function testUnoHas25CardsForEachColor()
    {
        foreach([Card::RED, Card::BLUE, Card::GREEN, Card::YELLOW] as $color){
            $cards = $this->game->drawPile()->filter(function(Card $card) use ($color){
                return $card->color() === $color;
            })->count();

            $this->assertTrue($cards === 25);
        }
    }

    /**
     * Test Uno has 4 of each type of Wild Cards
     */
    public function testUnoHas4OfEachTypeOfWildCards()
    {
        foreach([Card::WILD, Card::WILD_DRAW] as $type){
            $wilds = $this->game->drawPile()->filter(function(Card $card) use ($type){
                return $card->type() === $type;
            })->count();

            $this->assertTrue($wilds === 4);
        }
    }

    /**
     * Test Uno has 8 of each Action Card
     */
    public function testUnoHas8OfEachActionCard()
    {
        foreach([Card::SKIP, Card::DRAW, Card::REVERSE] as $type){
            $cards = $this->game->drawPile()->filter(function(Card $card) use ($type){
                return $card->type() === $type;
            })->count();

            $this->assertTrue($cards === 8);
        }
    }

    /**
     * Test Uno has All Numeric Cards for Each Color
     */
    public function testUnoHasAllNumericCardsForEachColor()
    {
        foreach([Card::RED, Card::BLUE, Card::GREEN, Card::YELLOW] as $color){
            for($i = 0; $i <= 9; $i++){
                $cards = $this->game->drawPile()->filter(function(Card $card) use ($color, $i){
                    return $card->color() === $color && $card->type() === Card::NUMERIC && $card->value() === $i;
                })->count();

                $this->assertTrue($cards === (($i === 0) ? 1 : 2));
            }
        }
    }
}
```

Each of these test functions are relatively straight forward. We're using the Collection class to simplify filtering down our draw pile to ensure each criteria is met, while using the rules as our baseline.

At the end our test results can be ran with **phpunit**

```bash
phpunit

PHPUnit 7.0.0 by Sebastian Bergmann and contributors.

.....                                                               5 / 5 (100%)

Time: 141 ms, Memory: 12.00MB

OK (5 tests, 50 assertions)
```
