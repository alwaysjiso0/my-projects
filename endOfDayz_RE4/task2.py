"""
A GUI-based zombie survival game wherein the player has to reach
the hospital whilst evading zombies.
"""

# Replace these <strings> with your name, student number and email address.
__author__ = "<Jisoo Choi>, <46495211>"
__email__ = "<s4649521@student.uq.edu.au>"

# Library Import
import tkinter as tk
import tkinter.filedialog as fd
from PIL import Image, ImageTk

from task1 import *


class StatusBar(tk.Frame):
    """ The chaser and chasee images.
    A frame holding:
    •
    • A game timer displaying the number of minutes and seconds the user
    has been playing the current game.
    • A moves counter, displaying how many moves the player has made in the current game.
    • A ‘Quit Game’ button, which ends the program.
    • A ‘Restart Game’ button, which allows the user to start the game again.
    """

    def __init__(self, root, **kw):
        # root = frame_c from ImageGraphicalInterface
        super().__init__(**kw)
        self._root = root

        # chaser image
        chaser_image = Image.open('images/chaser.png')
        chaser_photo = ImageTk.PhotoImage(chaser_image)
        self._chaser = tk.Label(self._root, image=chaser_photo, bg='white')
        self._chaser.image = chaser_photo
        self._chaser.pack(side=tk.LEFT, padx=30)

        # chasee image
        chasee_image = Image.open('images/chasee.png')
        chasee_photo = ImageTk.PhotoImage(chasee_image)
        self._chasee = tk.Label(self._root, image=chasee_photo, bg='white')
        self._chasee.image = chasee_photo
        self._chasee.pack(side=tk.RIGHT, padx=30)

        # timer (import time 안됨, step count랑 연결)
        self._timer = tk.Label(self._root, text='Timer\n0 mins 0 seconds', bg='white')
        # step 이용해서 시간 계산
        self._timer.pack(side=tk.LEFT, padx=50)

        # moves counter
        self._moves = tk.Label(self._root, text='Moves made\n0 moves', bg='white')
        # move_player 횟수 계
        self._moves.pack(side=tk.LEFT)

    def update_timer(self, game: Game) -> None:
        cur_time = game.get_steps()
        cur_min, cur_sec = divmod(cur_time, 60)

        self._timer.configure(text='Timer\n%2d mins %2d seconds' % (cur_min, cur_sec))

    def update_movement(self, move_count: int) -> None:
        self._moves.configure(text='Moves made\n%3d moves' % move_count)


class ImageMap(BasicMap):
    """
    """

    def __init__(self, master, size, **kwargs):
        super().__init__(master, size, **kwargs)

        self.size = size
        self.entity_images = {}

        for display, image_route in IMAGES.items():
            entity_image = ImageTk.PhotoImage(file=image_route)
            self.entity_images[display] = entity_image

    def draw_entity(self, position: Position, tile_type: str) -> None:
        """
        Draws the entity with tile type at the given position using a
        coloured rectangle with superimposed text identifying the entity.

        Parameters:
            position (Position): The (x, y) position of the entity to draw.
            tile_type (str): The display of the entity to draw.
        """
        entity_x_min, entity_y_min, entity_x_max, entity_y_max = self.get_bbox(position)

        for display, image_route in IMAGES.items():
            if tile_type == display:
                self.create_image(entity_x_min, entity_y_min, image=self.entity_images[display], anchor='nw')

    def draw_background(self):
        for col in range(self.size):
            for row in range(self.size):
                self.create_image(CELL_SIZE * col, CELL_SIZE * row,
                                  image=self.entity_images[BACK_GROUND], anchor='nw')


class HighScoresFrame(tk.Canvas):
    def __init__(self, master, width=250, height=50 * MAX_ALLOWED_HIGH_SCORES, **kwargs):
        super().__init__(master=master, width=width, height=height, **kwargs)
        self._master = master

        self.scores = {}

        frame_top = tk.Frame(self.master)
        self.top = tk.Label(frame_top, height=1, text="High Scores", bg=DARK_PURPLE,
                            fg='white', font=('Arial', 25))
        self.top.pack(fill=tk.BOTH, anchor=tk.CENTER)
        frame_top.pack(fill=tk.BOTH)

        self.done_button = tk.Button(self.master, text='Done', bg='white', command=self.close_frame)
        self.done_button.pack(side=tk.BOTTOM)

        try:
            f = open(HIGH_SCORES_FILE, 'r')
            lines = f.readlines()

            for info in lines:
                tmp = info.split()
                player_name, player_score = tmp
                player_score = int(player_score)
                self.scores[player_score] = self.scores.get(player_score, []) + [player_name]

            f.close()

            cnt = 0

            for score in sorted(self.scores):
                for name in self.scores[score]:
                    score_text = name + ': '
                    m, s = divmod(score, 60)

                    if m:
                        score_text += str(m) + 'm'

                    score_text += str(s) + 's'
                    self.info = tk.Label(self.master, text=score_text)
                    self.info.pack()
                    cnt += 1

                    if cnt == MAX_ALLOWED_HIGH_SCORES:
                        break

                if cnt == MAX_ALLOWED_HIGH_SCORES:
                    break
        except:
            print('?')
            pass

    def close_frame(self):
        self.master.destroy()


class WinPopup(tk.Canvas):
    def __init__(self, master, steps, width=250, height=100, **kwargs):
        super().__init__(master=master, width=width, height=height, **kwargs)
        self._master = master
        self.steps = steps

        self.descirption = tk.Label(self._master, text="You won in %dm and %ds! Enter your name:" %
                                                      (steps // 60, steps % 60))
        self.descirption.pack(fill=tk.BOTH)

        self.input_text = tk.Entry(self._master, width=20)
        self.input_text.pack()

        self.enter_button = tk.Button(self._master, text='Enter', bg='white', command=self.record_score)
        self.enter_replay_button = tk.Button(self._master, text='Enter and play again', bg='white',
                                             command=lambda: self.record_score)
        self.enter_button.pack(side=tk.LEFT)
        self.enter_replay_button.pack(side=tk.LEFT)

    def record_score(self):
        f = open(HIGH_SCORES_FILE, 'a')
        f.write(self.input_text.get() + ' ' + str(self.steps) + '\n')
        f.close()
        self._master.destroy()

    # def record_score_replay(self, game: Game):
    #     self.record_score()
    #
    #     new_game = advanced_game(MAP_FILE)
    #     game.__init__(new_game.get_grid())
    #     self.draw(game)
    #     self._step(game)


class ImageGraphicalInterface(BasicGraphicalInterface):
    """
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

        self.move_count = 0

        # frame_a: contains title label of the game
        frame_a = tk.Frame(root)
        banner_image = Image.open('images/banner.png')
        banner_photo = ImageTk.PhotoImage(banner_image.resize((700, BANNER_HEIGHT), Image.ANTIALIAS))
        self._title = tk.Label(frame_a, image=banner_photo, bg='white')
        self._title.image = banner_photo
        self._title.pack(fill=tk.BOTH, anchor=tk.CENTER)

        # frame_b: contains map and inventory vies of the game
        frame_b = tk.Frame(root, bg='white')
        self._basic = ImageMap(frame_b, size)
        self._basic.pack(side=tk.LEFT)

        self._inventory = InventoryView(frame_b, size, bg=LIGHT_PURPLE)
        self._inventory.pack(side=tk.LEFT)
        frame_a.pack(fill=tk.BOTH)
        frame_b.pack(fill=tk.BOTH)

        # frame_c: contains the status bar -> 해제하면 BasicMap, Inventory 안보
        canvas = tk.Canvas(root, bg='white')
        self.frame_c = StatusBar(canvas)
        canvas.pack(fill=tk.BOTH)
        canvas.config(highlightbackground='white')

    def set_menu_bar(self, game: Game) -> None:
        menuBar = tk.Menu(self._root)

        fileMenu = tk.Menu(menuBar)
        fileMenu.add_command(label="Restart game", command=lambda: self.restart_game(game))
        fileMenu.add_command(label="Save game", command=lambda: self.save_game(game))
        fileMenu.add_command(label="Load game", command=lambda: self.load_game(game))
        fileMenu.add_command(label="High scores", command=self.show_high_scores)
        fileMenu.add_command(label="Quit", command=self.quit_game)

        menuBar.add_cascade(label="File", menu=fileMenu)
        self._root.config(menu=menuBar)

    def save_game(self, game: Game) -> None:
        """"""
        self._stop()
        self._root.dirName = fd.asksaveasfilename(initialfile='game_save.txt',
                                                  filetypes=(("text files", "*.txt"),
                                                             ("all files", "*")))

        if self._root.dirName:
            map_state = [list(' ' * self._size) for _ in range(self._size)]
            mapping = game.get_grid().get_mapping()
            player = game.get_player()

            for position, entity in mapping.items():
                map_state[position.get_x()][position.get_y()] = entity.display()

            inv_state = player.get_inventory().get_items()

            f = open(self._root.dirName, 'w')
            f.write(TITLE + '\n')
            f.write(str(game.get_steps()) + '\n')
            f.write(str(self.move_count) + '\n')
            f.write(str(inv_state)[1: -1] + '\n')
            f.close()

            map_file_name = self._root.dirName.split('.')[0] + '_map.txt'
            f = open(map_file_name, 'w')
            for map_line in map_state:
                f.write(''.join(map_line) + '\n')
            f.close()

        self._step(game)
        self.draw(game)

    def load_game(self, game: Game) -> None:
        """"""
        self._stop()

        self._root.dirName = fd.askopenfilename(initialfile='game_save.txt',
                                                filetypes=(("text files", "*.txt"),
                                                           ("all files", "*")))

        map_file_name = self._root.dirName.split('.')[0] + '_map.txt'

        load_success = True

        try:
            f = open(map_file_name, 'r')
            f.close()
        except:
            load_success = False
            showerror(title="Load Failed", message="Can not load map file")

        if load_success:
            f = open(self._root.dirName, 'r')
            load_name = f.readline().rstrip()
            load_steps = int(f.readline())
            load_move_count = int(f.readline())
            load_inv_state = f.readline().rstrip()

            if load_name != TITLE:
                load_success = False
                showerror(title="Load Failed", message="You selected wrong file")

            f.close()

            if load_success:
                new_game = advanced_game(map_file_name)
                game.__init__(new_game.get_grid())
                game._steps = load_steps
                self.move_count = load_move_count
                self.frame_c.update_movement(self.move_count)

                player = game.get_player()
                player.get_inventory()

                for item_info in load_inv_state.split(', '):
                    item_name, item_rem = item_info[:-1].split('(')

                    if item_name == 'Garlic':
                        entity = Garlic()

                    elif item_name == 'Crossbow':
                        entity = Crossbow()

                    else:
                        entity = Pickup()

                    entity._lifetime = int(item_rem)
                    player.get_inventory().add_item(entity)

        self.draw(game)
        self._step(game)

    def show_high_scores(self) -> None:
        high_scores_tk = tk.Tk()
        high_scores_tk.title('Top {}'.format(MAX_ALLOWED_HIGH_SCORES))
        frame_s = HighScoresFrame(high_scores_tk)
        frame_s.pack()
        high_scores_tk.mainloop()

    def _win_popup(self, popup: str, game: Game) -> None:
        win_popup_tk = tk.Tk()
        win_popup_tk.title(popup)
        frame_w = WinPopup(win_popup_tk, game.get_steps())
        frame_w.pack()
        win_popup_tk.mainloop()

    def _handle_game(self, game: Game) -> None:
        """

        """
        if game.has_won():
            self._stop()
            self._win_popup(WIN_MESSAGE, game)

        elif game.has_lost():
            self._stop()
            self._popup(LOSE_MESSAGE, game)

        self._stop_game = False

    def _step(self, game: Game) -> None:
        self.frame_c.update_timer(game)
        super()._step(game)

    def _move(self, game: Game, direction: str) -> None:
        self.move_count += 1
        self.frame_c.update_movement(self.move_count)
        super()._move(game, direction)

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

        self._basic.draw_background()

        for position, entity in mapping.items():
            display = entity.display()
            self._basic.draw_entity(position, display)

        self._inventory.draw(player.get_inventory())
        self._handle_game(game)

    def play(self, game: Game) -> None:
        self.set_menu_bar(game)
        self.set_button_function(game)
        super().play(game)

    def set_button_function(self, game: Game):
        # quit or restart buttons
        self.frame_c.btn_frame = tk.Frame(self.frame_c._root, bg='white')
        self.frame_c.restart_btn = tk.Button(self.frame_c.btn_frame, text='Restart Game', bg='white',
                                             command=lambda: self.restart_game(game))
        self.frame_c.quit_btn = tk.Button(self.frame_c.btn_frame, text='Quit Game', bg='white',
                                          command=self.quit_game)

        self.frame_c.restart_btn.pack(side=tk.TOP)
        self.frame_c.quit_btn.pack(side=tk.TOP)
        self.frame_c.btn_frame.pack(side=tk.RIGHT, padx=50, pady=5)

    def restart_game(self, game: Game) -> None:
        self._stop()
        new_game = advanced_game(MAP_FILE)
        game.__init__(new_game.get_grid())
        self.draw(game)
        self._step(game)

    def quit_game(self) -> None:
        exit()


def main() -> None:
    """Entry point to gameplay."""
    game = advanced_game(MAP_FILE)

    root = tk.Tk()
    root.title('EndOfDayz')
    gui = ImageGraphicalInterface
    app = gui(root, game.get_grid().get_size())
    app.play(game)


if __name__ == '__main__':
    main()
