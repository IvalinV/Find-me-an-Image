<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Tetris extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tetris';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Play a game of Tetris in the terminal.';

    /**
     * The current state of the game board.
     *
     * @var array
     */
    protected $board;

    /**
     * The current piece being dropped.
     *
     * @var array
     */
    protected $piece;

    /**
     * The current position of the piece.
     *
     * @var array
     */
    protected $position = [0, 0];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Set up the game board
        $this->board = array_fill(0, 10, array_fill(0, 20, ' '));

        // Loop until game is over
        while (true) {
            // Clear the screen
            system('clear');

            // Display the game board
            $this->display();

            // Wait for user input
            $key = $this->readKey();

            // Handle user input
            switch ($key) {
                case 'q':
                    // Quit the game
                    $this->info('Goodbye!');
                    return 0;
                case 'a':
                    // Move piece left
                    $this->move([-1, 0]);
                    break;
                case 'd':
                    // Move piece right
                    $this->move([1, 0]);
                    break;
                case 's':
                    // Move piece down
                    $this->move([0, 1]);
                    break;
                default:
                    // Invalid input
                    $this->error('Invalid input.');
                    break;
            }

            // Check if game is over
            if (!$this->check()) {
                // Display game over message
                system('clear');
                $this->display();
                $this->error('Game over!');
                return 1;
            }
        }
    }

    /**
     * Move the piece to a new position.
     *
     * @param array $offset
     * @return void
     */
    protected function move($offset)
    {
        // Calculate the new position
        $newPosition = [$this->position[0] + $offset[0], $this->position[1] + $offset[1]];

        // Check if the new position is valid
        if ($this->isValidPosition($this->piece, $newPosition)) {
            // Erase the old piece
            $this->erase($this->piece, $this->position);

            // Update the position
            $this->position = $newPosition;

            // Draw the new piece
            $this->draw($this->piece, $this->position);
        }
    }

    /**
     * Check if the game is over.
     *
     * @return bool
     */
    protected function check()
    {
        // TODO: Implement game over logic
        return true;
    }

    /**
     * Display the game board.
     *
     * @return void
     */
    protected function display()
    {
        // Display the game board
        foreach ($this->board as $row) {
            foreach ($row as $cell) {
                $this->info("[{$cell}]");
            }
            $this->line('');
        }
    }

    /**
     * Draw a piece on the game board.
     *
     * @param array $piece
     * @param array $position
     * @return void
     */
    protected function draw($piece, $position)
    {
        // Draw the piece on the game board
        foreach ($piece as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($cell == '*') {
                    $this->board[$position[0] + $x][$position[1] + $y] = $cell;
                }
            }
        }
    }

    /**
     * Erase a piece from the game board.
     *
     * @param array $piece
     * @param array $position
     * @return void
     */
    protected function erase($piece, $position)
    {
        // Erase the piece from the game board
        foreach ($piece as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($cell == '*') {
                    $this->board[$position[0] + $x][$position[1] + $y] = ' ';
                }
            }
        }
    }

    /**
     * Check if a position is valid for a piece.
     *
     * @param array $piece
     * @param array $position
     * @return bool
     */
    protected function isValidPosition($piece, $position)
    {
        // Check if the piece would be off the left or right edge of the game board
        if ($position[0] < 0 || $position[0] + count($piece[0]) > count($this->board)) {
            return false;
        }

        // Check if the piece would be off the bottom of the game board
        if ($position[1] + count($piece) > count($this->board[0])) {
            return false;
        }

        // Check if the piece would collide with another piece on the game board
        foreach ($piece as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($cell == '*' && $this->board[$position[0] + $x][$position[1] + $y] != ' ') {
                    return false;
                }
            }
        }

        // Position is valid
        return true;
    }

    /**
     * Read a single key from the user.
     *
     * @return string
     */
    protected function readKey()
    {
        // Disable input buffering
        system('stty -icanon');

        // Read a single character from the user
        $char = fread(STDIN, 1);

        // Enable input buffering
        system('stty icanon');

        // Return the character
        return $char;
    }
}    
