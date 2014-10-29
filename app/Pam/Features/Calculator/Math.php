<?php namespace Pam\Features\Calculator;

/**
 * This package is taken from GitHub
 * @url https://gist.github.com/ircmaxell/1232629
 */

//Expressions
class Parenthesis extends TerminalExpression {
 
    protected $precidence = 6;
 
    public function operate(Stack $stack) {
    }
 
    public function getPrecidence() {
        return $this->precidence;
    }
 
    public function isNoOp() {
        return true;
    }
 
    public function isParenthesis() {
        return true;
    }
 
    public function isOpen() {
        return $this->value == '(';
    }
 
}
 
class Number extends TerminalExpression {
 
    public function operate(Stack $stack) {
        return $this->value;
    }
 
}
 
abstract class Operator extends TerminalExpression {
 
    protected $precidence = 0;
    protected $leftAssoc = true;
 
    public function getPrecidence() {
        return $this->precidence;
    }
 
    public function isLeftAssoc() {
        return $this->leftAssoc;
    }
 
    public function isOperator() {
        return true;
    }
 
}
 
class Addition extends Operator {
 
    protected $precidence = 4;
 
    public function operate(Stack $stack) {
        return $stack->pop()->operate($stack) + $stack->pop()->operate($stack);
    }
 
}
 
class Subtraction extends Operator {
 
    protected $precidence = 4;
 
    public function operate(Stack $stack) {
        $left = $stack->pop()->operate($stack);
        $right = $stack->pop()->operate($stack);
        return $right - $left;
    }
 
}
 
class Multiplication extends Operator {
 
    protected $precidence = 5;
 
    public function operate(Stack $stack) {
        return $stack->pop()->operate($stack) * $stack->pop()->operate($stack);
    }
 
}
 
class Division extends Operator {
 
    protected $precidence = 5;
 
    public function operate(Stack $stack) {
        $left = $stack->pop()->operate($stack);
        $right = $stack->pop()->operate($stack);
        return $right / $left;
    }
 
}

// Stack
class Stack {
 
    protected $data = array();
 
    public function push($element) {
        $this->data[] = $element;
    }
 
    public function poke() {
        return end($this->data);
    }
 
    public function pop() {
        return array_pop($this->data);
    }
 
}


// Terminal Esxpression
abstract class TerminalExpression {
 
    protected $value = '';
 
    public function __construct($value) {
        $this->value = $value;
    }
 
    public static function factory($value) {
        if (is_object($value) && $value instanceof TerminalExpression) {
            return $value;
        } elseif (is_numeric($value)) {
            return new Number($value);
        } elseif ($value == '+') {
            return new Addition($value);
        } elseif ($value == '-') {
            return new Subtraction($value);
        } elseif ($value == '*') {
            return new Multiplication($value);
        } elseif ($value == '/') {
            return new Division($value);
        } elseif (in_array($value, array('(', ')'))) {
            return new Parenthesis($value);
        }
        throw new Exception('Undefined Value ' . $value);
    }
 
    abstract public function operate(Stack $stack);
 
    public function isOperator() {
        return false;
    }
 
    public function isParenthesis() {
        return false;
    }
 
    public function isNoOp() {
        return false;
    }
 
    public function render() {
        return $this->value;
    }
}

// Match
class Math {
 
    protected $variables = array();
 
    public function evaluate($string) {
        $stack = $this->parse($string);
        return $this->run($stack);
    }
 
    public function parse($string) {
        $tokens = $this->tokenize($string);
        $output = new Stack();
        $operators = new Stack();
        foreach ($tokens as $token) {
            $token = $this->extractVariables($token);
            $expression = TerminalExpression::factory($token);
            if ($expression->isOperator()) {
                $this->parseOperator($expression, $output, $operators);
            } elseif ($expression->isParenthesis()) {
                $this->parseParenthesis($expression, $output, $operators);
            } else {
                $output->push($expression);
            }
        }
        while (($op = $operators->pop())) {
            if ($op->isParenthesis()) {
                throw new RuntimeException('Mismatched Parenthesis');
            }
            $output->push($op);
        }
        return $output;
    }
 
    public function registerVariable($name, $value) {
        $this->variables[$name] = $value;
    }
 
    public function run(Stack $stack) {
        while (($operator = $stack->pop()) && $operator->isOperator()) {
            $value = $operator->operate($stack);
            if (!is_null($value)) {
                $stack->push(TerminalExpression::factory($value));
            }
        }
        return $operator ? $operator->render() : $this->render($stack);
    }
 
    protected function extractVariables($token) {
        if ($token[0] == '$') {
            $key = substr($token, 1);
            return isset($this->variables[$key]) ? $this->variables[$key] : 0;
        }
        return $token;
    }
 
    protected function render(Stack $stack) {
        $output = '';
        while (($el = $stack->pop())) {
            $output .= $el->render();
        }
        if ($output) {
            return $output;
        }
        throw new RuntimeException('Could not render output');
    }
 
    protected function parseParenthesis(TerminalExpression $expression, Stack $output, Stack $operators) {
        if ($expression->isOpen()) {
            $operators->push($expression);
        } else {
            $clean = false;
            while (($end = $operators->pop())) {
                if ($end->isParenthesis()) {
                    $clean = true;
                    break;
                } else {
                    $output->push($end);
                }
            }
            if (!$clean) {
                throw new RuntimeException('Mismatched Parenthesis');
            }
        }
    }
 
    protected function parseOperator(TerminalExpression $expression, Stack $output, Stack $operators) {
        $end = $operators->poke();
        if (!$end) {
            $operators->push($expression);
        } elseif ($end->isOperator()) {
            do {
                if ($expression->isLeftAssoc() && $expression->getPrecidence() <= $end->getPrecidence()) {
                    $output->push($operators->pop());
                } elseif (!$expression->isLeftAssoc() && $expression->getPrecidence() < $end->getPrecidence()) {
                    $output->push($operators->pop());
                } else {
                    break;
                }
            } while (($end = $operators->poke()) && $end->isOperator());
            $operators->push($expression);
        } else {
            $operators->push($expression);
        }
    }
 
    protected function tokenize($string) {
        $parts = preg_split('((\d+|\+|-|\(|\)|\*|/)|\s+)', $string, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        $parts = array_map('trim', $parts);
        return $parts;
    }
 
}