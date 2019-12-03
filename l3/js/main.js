window.addEventListener("load", () => {
    console.log("XD")
    const canvas = document.getElementById("canvas");
    load_img_into_canvas("images/img1.jpg", canvas)
});

function load_img_into_canvas(img_path, canvas) {
    const img = new Image();
    img.src = img_path;
    img.addEventListener("load", () => {
        canvas.width = img.width;
        canvas.height = img.height;
        let puzzle = new Puzzle(3, img);
        puzzle.draw_tiles(canvas)
        canvas.addEventListener("click", event => {
            const rect = canvas.getBoundingClientRect()
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            const coords = puzzle.getTileCoords(x, y);
            if (puzzle.isMovable(coords)) {
                console.log("I pressed puzzle:", puzzle.getTileCoords(coords))
                puzzle.slide(puzzle.getTileIndexByCoords(coords))
                puzzle.draw_tiles(canvas)
            }
        });
    });
}

class Puzzle {
    constructor(n, img) {
        this.n = n;
        this.img = img;
        this.size = img.height/n;
        this.tiles = [];
        this.init_tiles();
    }

    init_tiles () {
        this.tiles.push(null);
        for (let i = 0; i < this.n; i++) {
            for (let j = 0; j < this.n; j++) {
                if (i > 0 || j > 0) {
                    this.tiles.push(new Tile(i*this.size, j*this.size, i*this.n + j));
                }
            }
        }
        do {
            this.shuffleTiles();
        } while (!this.isSolvable())
    }

    shuffleTiles () {
        for (let i = this.tiles.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            if (i > 0 && j > 0)
                [this.tiles[i], this.tiles[j]] = [this.tiles[j], this.tiles[i]];
        }
    }

    draw_tiles (canvas) {
        const ctx = canvas.getContext("2d");
        ctx.fillStyle = "#b71c1c";
        ctx.fillRect(0, 0, canvas.width, canvas.height)
        for (let i = 0; i < this.n; i++) {
            for (let j = 0; j < this.n; j++) {
                let tile = this.tiles[i*this.n + j]
                if (tile !== null) {
                    ctx.drawImage(this.img, tile.sx, tile.sy, this.size, this.size, i*this.size, j*this.size, this.size, this.size)
                }
            }
        }
    }

    isMovable(coords) {
        const i = coords.i;
        const j = coords.j;
        const utileIndex = (i - 1) >= 0     ? (i - 1) * this.n + j       : undefined;
        const dtileIndex = (i + 1) < this.n ? (i + 1) * this.n + j       : undefined;
        const ltileIndex = (j - 1) >= 0     ?  i      * this.n + (j - 1) : undefined;
        const rtileIndex = (j + 1) < this.n ?  i      * this.n + (j + 1) : undefined;
        return [utileIndex, dtileIndex, ltileIndex, rtileIndex].includes(this.getBlankIndex());
    }

    getBlankIndex() {
        return this.tiles.findIndex(t => t === null);
    }

    countInversions(j, i) {
        let inversions = 0;
        let tileNum = i * this.n + j;
        if (tileNum === this.getBlankIndex()) return 0
        let lastTile = this.n * this.n;
        let tileValue = this.tiles[tileNum].id;
        for (let q = tileNum + 1; q < lastTile; ++q) {
            let k = q % this.n;
            let l = Math.floor(q / this.n);
            let index = k * this.n + l;
            if (this.tiles[index] !== null) {
                let compValue = this.tiles[index].id
                if (tileValue > compValue && tileValue != (lastTile - 1)) {
                    ++inversions;
                }
            }  
        }
        return inversions;
    }

    sumInversions() {
        let inversions = 0;
        for (let i = 0; i < this.n; ++i) {
            for (let j = 0; j < this.n; ++j) {
                inversions += this.countInversions(i, j);
            }
        }
        return inversions;
    }

    isSolvable() {
        if (this.n % 2 == 1) {
            return (this.sumInversions() % 2 == 0);
        } else {
            return ((this.sumInversions() + this.n) % 2 == 0)
        }
    }

    getTileCoords(x, y) {
        let i = (x - x % this.size) / this.size;
        let j = (y - y % this.size) / this.size;
        return {"i": i, "j": j};
    }

    getTileIndexByCoords(coords) {
        return coords.i * this.n + coords.j;
    }

    slide(tileIndex) {
        if (this.tiles[tileIndex] === null) return
        let blankIndex = this.getBlankIndex();
        this.tiles[blankIndex] = this.tiles[tileIndex];
        this.tiles[tileIndex] = null;
    }
}

class Tile {
    constructor(sx, sy, id) {
        this.sx = sx;
        this.sy = sy;
        this.id = id;
    }
}
