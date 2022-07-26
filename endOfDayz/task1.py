"""
A GUI-based zombie survival game wherein the player has to reach
the hospital whilst evading zombies.
"""

# Replace these <strings> with your name, student number and email address.
__author__ = "<Jisoo Choi>, <46495211>"
__email__ = "<s4649521@student.uq.edu.au>"

# Library Import
import tkinter as tk
from tkinter.messagebox import *

from a2_solution import *
from constants import *


class AbstractGrid(tk.Canvas):
    """
    AbstractGrid is an abstract view class which inherits from tk.Canvas
    and provides base functionality for other view classes.
    """

    def __init__(self, master, rows, cols, width, height, **kwargs):
        """
        Parameters:
            master (Tk): The window of the gui created.
            rows (int): The number of rows in the grid.
            cols (int): The number of columns in the grid
            width (int): The pixel width of the grid.
            height (int): The pixel height of the grid.
            **kwargs: any additional named arguments supported by tk.Canvas.
        """
        super().__init__(master=master, width=width, height=height, **kwargs)
        self._master = master
        self._rows = rows
        self._cols = cols
        self._width = width
        self._height = height

        self._cellWidth = width / cols
        self._cellHeight = height / rows

    def get_bbox(self, position: Position) -> tuple:
        """
        Parameters:
            position (Position): The (row, column) position of a box.

        Returns:
            The bounding box for the (row, column) position;
            this is a tuple containing information about the pixel positions of the edges of
            the shape, in the form (x min, y min, x max, y max)
        """
        pos_x = position.get_x()
        pos_y = position.get_y()

        pos_x_min = pos_x * self._cellWidth
        pos_y_min = pos_y * self._cellHeight

        pos_x_max = (pos_x + 1) * self._cellWidth
        pos_y_max = (pos_y + 1) * self._cellHeight

        return pos_x_min, pos_y_min, pos_x_max, pos_y_max

    def pixel_to_position(self, pixel: tuple) -> Position:
        """
        Converts the (x, y) pixel position (in graphics units) to a (row, column) position.

        Parameters:
            pixel (tuple): The (x, y) pixel position (in graphics units).

        Returns:
            position (Position): A (row, column) position.
        """
        pixel_x, pixel_y = pixel

        pixel_pos_x = (pixel_x // self._cellWidth)
        pixel_pos_y = (pixel_y // self._cellHeight)

        return Position(pixel_pos_x, pixel_pos_y)

    def get_position_center(self, position: Position) -> tuple:
        """
        Gets the graphics coordinates for the center
        of the cell at the given (row, column) position.

        Parameters:
            position (Position): the position of the box to get the center coordinates of.

        Returns:
            Pixel coordinates of the center of the parameter box.
        """
        pix_x_min, pix_y_min, pix_x_max, pix_y_max = self.get_bbox(position)

        pix_center_x = (pix_x_min + pix_x_max) / 2
        pix_center_y = (pix_y_min + pix_y_max) / 2

        return pix_center_x, pix_center_y

    def annotate_position(self, position: Position, text: str, **kwargs) -> None:
        """
         Annotates the center of the cell at the given (row, column) position
         with the provided text.

         Parameters:
             position (Position): The position of the box to annotate the text at the center.
             text (str): The text to be written in the position.
        """
        pos_center = self.get_position_center(position)

        if text == PLAYER or text == HOSPITAL:
            self.create_text(pos_center[0], pos_center[1], text=text, fill='#FFFFFF')

        else:
            self.create_text(pos_center[0], pos_center[1], text=text, **kwargs)


class BasicMap(AbstractGrid):
    """
    BasicMap is a view class which inherits from AbstractGrid.
    Entities are drawn on the map using coloured rectangles
    at different (row, column) positions.
    """

    def __init__(self, master, size, **kwargs):
        """
        Parameters:
            master (Tk): The window of the gui created.
            size (int): The number of rows (= number of columns) in the grid.
            **kwargs: any additional named arguments supported by tk.Canvas.
        """
        super().__init__(master=master, rows=size, cols=size, width=CELL_SIZE * size,
                         height=CELL_SIZE * size, **kwargs)

    def draw_entity(self, position: Position, tile_type: str) -> None:
        """
        Draws the entity with tile type at the given position using a
        coloured rectangle with superimposed text identifying the entity.

        Parameters:
            position (Position): The (x, y) position of the entity to draw.
            tile_type (str): The display of the entity to draw.
        """
        x_min, y_min, x_max, y_max = self.get_bbox(position)

        for key, value in ENTITY_COLOURS.items():
            if key == tile_type:
                self.create_rectangle(x_min, y_min, x_max, y_max, fill=value)
                self.annotate_position(position, key)


class InventoryView(AbstractGrid):
    """
    InventoryView is a view class which inherits from AbstractGrid and displays the items
    the player has in their inventory. This class also provides a mechanism through which
    the user can activate an item held in the player’s inventory. When a player picks up
    an item it is added to the inventory and displayed in the next free row in the
    inventory view, along with its maximum lifetime.
    """

    def __init__(self, master, rows, **kwargs):
        """
        Parameters:
            master (Tk): This is the window that our GUI is created in.
            rows (int): The number of rows in the InventoryView.
        """
        super().__init__(master=master, rows=rows, cols=2, width=INVENTORY_WIDTH,
                         height=CELL_SIZE * rows, **kwargs)

    def get_row_bbox(self, row: int) -> tuple:
        """
        Draws the box for each item in the InventoryView. (item, lifetime)

        Parameters:
            row (int): The row an item is located.
        """
        x_min = self.get_bbox(Position(0, row))[0]
        y_min = self.get_bbox(Position(0, row))[1]
        x_max = self.get_bbox(Position(1, row))[2]
        y_max = self.get_bbox(Position(1, row))[3]

        return x_min, y_min, x_max, y_max

    def draw(self, inventory: Inventory) -> None:
        """
        Draws the inventory label and current items with their remaining lifetimes.

        Parameters:
            inventory (Inventory): The inventory holding items player picked up.(item, lifetime)
        """
        self.delete("all")

        # Inventory label
        self.create_text(100, 25, text='Inventory', fill=DARK_PURPLE, font=('Roboto', 16))

        # Print the current items with their remaining lifetimes.
        for index, item in enumerate(inventory.get_items()):
            index += 1

            if item.is_active():
                item_bg = DARK_PURPLE
                item_text = 'white'

            else:
                item_bg = LIGHT_PURPLE
                item_text = 'black'

            self.create_rectangle(self.get_row_bbox(index), fill=item_bg, width=0)
            self.annotate_position(Position(0, index), type(item).__name__, fill=item_text)
            self.annotate_position(Position(1, index), str(item.get_lifetime()), fill=item_text)

    def toggle_item_activation(self, pixel: tuple, inventory: Inventory) -> None:
        """
        Activates or deactivates the item (if one exists) in the row containing the pixel.

        Parameters:
            pixel (tuple): The (x, y) pixel position on click (in graphics units).
            inventory (Inventory): The inventory holding items player picked up.(item, lifetime)
        """
        items = inventory.get_items()
        index = int(self.pixel_to_position(pixel).get_y()) - 1

        if 0 <= index < len(items):
            if items[index].is_active() or (not inventory.any_active()):
                items[index].toggle_active()
                self.draw(inventory)


class BasicGraphicalInterface:
    """
    The BasicGraphicalInterface should manage the overall view
    (i.e. constructing the three major widgets) and event handling.
    """

    def __init__(self, root, size):
        """
        Parameters:
            root (tk): The root window.
            size (int): The number of rows (= number of columns) in the game map.
        """
        self._root = root
        self._size = size
        self._stop_game = False

        # frame_a: contains title label of the game
        frame_a = tk.Frame(root)
        self._title = tk.Label(frame_a, height=1, text=TITLE, bg=DARK_PURPLE,
                               fg='white', font=('Roboto', 20))
        self._title.pack(fill=tk.BOTH, anchor=tk.CENTER)

        # frame_b: contains map and inventory vies of the game
        frame_b = tk.Frame(root)
        self._basic = BasicMap(frame_b, size, bg=MAP_BACKGROUND_COLOUR)
        self._basic.pack(side=tk.LEFT)
        self._inventory = InventoryView(frame_b, size, bg=LIGHT_PURPLE)
        self._inventory.pack(side=tk.LEFT)
        frame_a.pack(fill=tk.BOTH)
        frame_b.pack(fill=tk.BOTH)

    def _inventory_click(self, event: tk.Event, inventory: Inventory) -> None:
        """
        This method should be called when the user left clicks on inventory view.
        It must handle activating or deactivating the clicked item (if one exists)
        and update both the model and the view accordingly.

        Parameters:
            event (tk.Event): The event to happen when user clicks.
            inventory (Inventory): The inventory holding items player picked up.
        """
        pixel = (event.x, event.y)
        self._inventory.toggle_item_activation(pixel, inventory)

    def _stop(self) -> None:
        """
        Stops the step method of the game when game ends.
        """
        self._root.after_cancel(tk.after_id)

    def _popup(self, popup: str, game: Game) -> None:
        """
        Asks the user if they want to play the game again once the game ends.

        Parameters:
            popup (str): The popup message stating whether the user won or lost the game.
            game (Game): The current game being played.
        """
        if askyesno(popup, 'Do you want to restart the game?'):
            new_game = advanced_game(MAP_FILE)
            game.__init__(new_game.get_grid())
            self.draw(game)
            self._step(game)

        else:
            exit()

    def _handle_game(self, game: Game) -> None:
        """
        Handles the game to end when the user wins or loses.

        Parameters:
            game (Game): The current game being played.

        Returns:
            True when the game ends and a message pops up.
        """
        if game.has_won():
            self._stop()
            self._popup(WIN_MESSAGE, game)

        elif game.has_lost():
            self._stop()
            self._popup(LOSE_MESSAGE, game)

        self._stop_game = False

    def draw(self, game: Game) -> None:
        """
        Clears and redraws the view based on the current game state.

        Parameters:
            game (Game): The current game being played.
        """
        # Deletes all existing view before redrawing.
        self._basic.delete('all')

        # Redraws map entities and inventory.
        mapping = game.get_grid().get_mapping()
        player = game.get_player()

        for position, entity in mapping.items():
            display = entity.display()
            self._basic.draw_entity(position, display)

        self._inventory.draw(player.get_inventory())
        self._handle_game(game)

    def _move(self, game: Game, direction: str) -> None:
        """
        Handles moving the player and redrawing the game.

        Parameters:
            game (Game): The current game being played.
            direction (str): w(UP), a(LEFT), s(DOWN), d(RIGHT)
        """
        offset = game.direction_to_offset(direction)
        game.move_player(offset)
        self.draw(game)

    def _step(self, game: Game) -> None:
        """
        The step method is called every second. This method triggers the step
        method for the game and updates the view accordingly.

        Parameters:
            game (Game): The current game being played.
        """
        game.step()
        tk.after_id = self._root.after(1000, self._step, game)
        self.draw(game)

    def play(self, game: Game) -> None:
        """
        Binds events and initialises gameplay.

        Parameters:
            game (Game): The current game being played.
        """
        self._basic.focus_set()

        def _move_key(event) -> None:
            """
            Changes the keypress input event into uppercase characters as required,
            and calls the _move method.
            """
            self._move(game, event.char.upper())

        def _crossbow_fire(event) -> None:
            """
            Fires the crossbow in the direction input (keyboard arrow keys)
            If the first target in the shooting direction is a Zombie or a TrackingZombie,
            the shooted entity gets removed from the grid.
            """
            grid = game.get_grid()
            player = game.get_player()
            inventory = player.get_inventory()

            if inventory.has_active(CROSSBOW):
                direction = ARROWS_TO_DIRECTIONS[event.keysym]
                player_pos = grid.find_player()
                offset = game.direction_to_offset(direction)
                target = first_in_direction(grid, player_pos, offset)

                # Check if there is a target in the shooting direction
                # Check if the first target is a Zombie or a TrackingZombie
                if (target is not None) and (target[1].display() in ZOMBIES):
                    position, entity = target
                    grid.remove_entity(position)

        def _click_item(event) -> None:
            """
            Manage the left click on inventory view
            """
            self._inventory_click(event, game.get_player().get_inventory())

        self._basic.bind('<w>', _move_key)
        self._basic.bind('<a>', _move_key)
        self._basic.bind('<s>', _move_key)
        self._basic.bind('<d>', _move_key)
        self._basic.bind('<Up>', _crossbow_fire)
        self._basic.bind('<Down>', _crossbow_fire)
        self._basic.bind('<Left>', _crossbow_fire)
        self._basic.bind('<Right>', _crossbow_fire)
        self._inventory.bind('<Button-1>', _click_item)

        self._step(game)
        self.draw(game)
        self._root.mainloop()


def main() -> None:
    """Entry point to gameplay."""
    game = advanced_game(MAP_FILE)

    root = tk.Tk()
    root.title('EndOfDayz')
    gui = BasicGraphicalInterface
    app = gui(root, game.get_grid().get_size())
    app.play(game)


if __name__ == '__main__':
    main()
