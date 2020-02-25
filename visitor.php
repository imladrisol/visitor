<?php

interface Entity
{
    public function accept(Visitor $visitor): string;
}

class Recipe implements Entity
{
    private $name;

    private $ingridients;

    public function __construct(string $name, array $ingridients)
    {
        $this->name = $name;
        $this->ingridients = $ingridients;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIngridients(): array
    {
        return $this->ingridients;
    }

    public function accept(Visitor $visitor): string
    {
        return $visitor->visitRecipe($this);
    }
}

class Ingridient implements Entity
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function accept(Visitor $visitor): string
    {
        return $visitor->visitIngridient($this);
    }
}

interface Visitor
{
    public function visitRecipe(Recipe $recipe): string;

    public function visitIngridient(Ingridient $ingridient): string;
}

class PizzaReport implements Visitor
{
    public function visitRecipe(Recipe $recipe): string
    {
        $output = "";

        foreach ($recipe->getIngridients() as $ingridient) {
            $output .= "\n--" . $this->visitIngridient($ingridient);
        }

        $output = $recipe->getName() ."\n" . $output;

        return $output;
    }

    public function visitIngridient(Ingridient $ingridient): string
    {
        $output = "";

        $output = $ingridient->getName() ."\n";

        return $output;
    }
}

$bacon = new Ingridient("Bacon");
$cheese = new Ingridient("Cheese");
$pineapple = new Ingridient("Pineapple");

$recipeChillyPizza = new Recipe("Chilly Pizza", [$bacon, $cheese, $pineapple]);
$report = new PizzaReport;
echo "Output whole recipe of pizza:\n\n";
echo $recipeChillyPizza->accept($report);

$recipeChillyPizza = new Recipe("Italian Pizza", [$cheese, $pineapple]);
$report = new PizzaReport;
echo "\nOutput whole recipe of pizza:\n\n";
echo $recipeChillyPizza->accept($report);
