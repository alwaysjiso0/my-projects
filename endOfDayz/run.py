"""
A GUI-based zombie survival game wherein the player has to reach
the hospital whilst evading zombies.
"""

# Replace these <strings> with your name, student number and email address.
__author__ = "Jisoo Choi, 46495211"
__email__ = "s4649521@student.uq.edu.au"

# LIBRARY IMPORT
import tkinter as tk
from a2_solution import advanced_game
from constants import TASK, MAP_FILE

# Uncomment the following imports to import the view classes that represent
# the GUI for each of the tasks that you implement in the assignment.
from task1 import BasicGraphicalInterface
from task2 import ImageGraphicalInterface


def main() -> None:
    """Entry point to gameplay."""
    global game

    game = advanced_game(MAP_FILE)

    root = tk.Tk()
    root.title('EndOfDayz')

    if TASK == 1:
        gui = BasicGraphicalInterface

    elif TASK == 2:
        gui = ImageGraphicalInterface

    app = gui(root, game.get_grid().get_size())
    app.play(game)


if __name__ == '__main__':
    main()