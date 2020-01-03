<?php include('counter.php') ?>
<!DOCTYPE html>
<html lang="pl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, ">
    <title>Zakamarki Kryptografii</title>
    <link rel="stylesheet" href="css/style.css?v=1.0">
    <link href="https://fonts.googleapis.com/css?family=EB+Garamond:400,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
  </head>

  <body>
    <script>
      window.MathJax = {
        tex: {
          inlineMath: [['$', '$']]
        },
        options: {
          skipHtmlTags: ["script", "style", "textarea"]
        }
      };
    </script>

    <div id="menu">
      <?php
        if (isset($_COOKIE["username"])) {
      ?>
        <button>Logout</button>
      <?php
        } else {
      ?>
        <button>Register</button>
        <button>Login</button>
      <?php
        }
      ?>
    </div>

    <main>
      <header id="title">
        <h1>Zakamarki Kryptografii</h1>
      </header>
      <nav>
        <a href='#goldwasser'>Schemat Goldwasser-Micali</a>
        <a href='#residue'>Reszta kwadratowa</a>
        <a href='#symbols'>Symbol Legendre'a i Jacobiego</a>
        <a href='#shamir'>Schemat progowy $(t, n)$ dzielenia sekretu Shamira</a>
        <a href='#lagrange'>Interpolacja Lagrange'a</a>
        <a href='#example'>Przykład</a>
      </nav>

      <section id="goldwasser">
        <header>
          <h2>Schemat Goldwasser-Micali szyfrowania probabilistycznego</h2>
        </header>
        <h4>Algorytm generowania kluczy</h4>
        <p>
          <ol type='a'>
            <li>Wybierz losowo dwie duże liczby pierwsze $p$ oraz $q$ (podobnego rozmiaru),</li>
            <li>Policz $n = pq$</li>
            <li>Wybierz $y \in \mathbb{Z}_n$, takie, że $y$ jest nieresztą kwadratową modulo $n$ i symbol Jacobiego
              $\left( \frac{y}{n} = 1 \right)$ (czyli $y$ jest pseudokwadratem modulo $n$),</li>
            <li>Klucz publiczny stanowi para $(n, y)$, zaś odpowiadający mu klucz prywatny to para $(p, q)$.</li>
          </ol>
        </p>
        <h4>Algorytm szyfrowania</h4>
        <p>
          Chcąc zaszyfrować wiadomość $m$ przy uzyciu klucza publicznego $(n, y)$ wykonaj kroki:
          <ol type='a'>
            <li>Przedstaw $m$ w postaci łańcycha binarnego $m = m_1m_2...m_t$ długości $t$</li>
            <li>
              <pre>
                For $i$ from $1$ to $t$ do
                    wybierz losowe $x \in \mathbb{Z}^*_n$
                    If $m_i = 1$ then set $c_i \leftarrow yx^2$ mod $n$
                    Otherwise set $c_i \leftarrow x^2$ mod $n$</pre>
                          </li>
                          <li>Kryptogram wiadomości $m$ stanowi $c = (c_1, c_2, ..., c_t)$</li>
                        </ol>
                      </p>
                      <h4>Algorytm deszyfrowania</h4>
                      <p>
                        Chcąc odzyskać wiadomości z kryptogramu $c$ przy uzyciu klucza prywatnego $(p, q)$ wykonaj kroki:
                        <ol type='a'>
                          <li>
                            <pre>
                For $i$ from $1$ to $t$ do
                    policz symbol Legendre'a $c_i = \left( \frac{c_i}{p} \right)$
                    If $c_i = 1$ then set $m_i \leftarrow 0$
                    Otherwise set $m_i \leftarrow 1$</pre>
                          </li>
                          <li>Zdeszyfrowana wiadomość to $m = m_1m_2...m_t$</li>
                        </ol>
                      </p>
                    </section>

                    <section id="residue">
                      <header>
                        <h2>Reszta/niereszta kwadratowa</h2>
                        <p>
                          <b>Definicja.</b> Niech $a \in \mathbb{Z}_n$. Mówimy, że $a$ jest <i>resztą kwadratową modulo $n$ (kwadratem
                            modulo $n$</i>, jeżeli istnieje $x \in \mathbb{Z}^*_n$ takie, że $x^2 \equiv a (\mod p)$. Jeżeli takie
                          $x$
                          nie istnieje, to wówczas $a$ nazywamy <i>nieresztą kwadratową modulo $n$</i>. Zbiór wszystkich reszt
                          kwadratowych modulo $n$ oznaczamy $Q_n$, zaś zbiór wszystkich niereszt kwadratowych modulo $n$ oznaczamy
                          $\bar{Q}_n$.
                        </p>
                      </header>
                    </section>

                    <section id="symbols">
                      <header>
                        <h2>Symbol Legendre'a i Jacobiego</h2>
                      </header>
                      <p>
                        <b>Defincja.</b> Niech $p$ będzie nieparzystą liczbą pierwszą, a $a$ liczbą całkowitą.<br>
                        <i>Symbol Legendre'a</i> $\left( \frac{a}{p}\right)$ jest zdefiniowany jako:
                        $$\left( \frac{a}{p} \right )= \left\{ \begin{array}{lll}
                        & 0 & \textrm{jeżeli $p | a$}\\
                        & 1 & \textrm{jeżeli $a \in Q_p$}\\
                        & -1 & \textrm{jeżeli $a \in \bar{Q}_p$}\\
                        \end{array} \right.
                        $$
                      </p>
                      <p>
                        <b>Własności symbolu Legendre'a.</b> Niech $a, b \in \mathbb{Z}$, zaś $p$ to nieparzysta liczba pierwsza.
                        Wówczas:
                        <ul>
                          <li>$\left( \frac{a}{p} \right) \equiv a^{\frac{(p-1)}{2}} (\mod p)$</li>
                          <li>$\left( \frac{ab}{p} \right) = \left( \frac{a}{p} \right) \left( \frac{b}{p} \right)$</li>
                          <li>$a \equiv b (\mod p) \Rightarrow \left( \frac{a}{p} \right) = \left( \frac{b}{p} \right)$</li>
                          <li>$\left( \frac{2}{p} \right) = (-1)^{\frac{(p^2 - 1)}{8}}$</li>
                          <li>Jeżeli $q$ jest nieparzystą liczbą pierwszą inną od $p$ to:
                            $$\left( \frac{p}{q} \right) = \left( \frac{q}{p} \right) (-1)^{\frac{(p - 1)(q - 1)}{4}}$$
                          </li>
                        </ul>
                      </p>
                      <p>
                        <b>Definicja.</b> Niech $n \geqslant 3$ będzie liczbą nieparzystą, a jej rozkład na czynniki pierwsze to $n =
                        p^{e_1}_1 p^{e_2}_2 \ldots p^{e_k}_k$. <i>Symbol Jacobiego</i> $\left( \frac{a}{n} \right)$ jest
                        zdefiniowany
                        jako:
                        $$\bigg( \frac{a}{n} \bigg) = \left( \frac{a}{p_1} \right)^{e_1} \left( \frac{a}{p_2} \right)^{e_2} \ldots
                        \left( \frac{a}{p_k} \right)^{e_k} $$
                        Jeżeli $n$ jest liczbą pierwszą, to symbol Jacobiego jest symbolem Legendre'a.
                      </p>
                      <p>
                        <b>Własności symbolu Jacobiego.</b> Niech $a, b \in \mathbb{Z}$, zaś $m, n \geqslant 3$ to nieparzyste liczby
                        całkowite. Wówczas:
                        <ul>
                          <li>$\left( \frac{a}{n} \right) = 0, 1$, albo -1. Ponadto $\left( \frac{a}{n} \right) = 0 \iff gcd(a, n)
                            \neq 1$</li>
                          <li>$\left( \frac{ab}{n} \right) = \left( \frac{a}{n} \right) \left( \frac{b}{n} \right)$</li>
                          <li>$\left( \frac{a}{mn} \right) = \left( \frac{a}{m} \right) \left( \frac{a}{n} \right)$</li>
                          <li>$a \equiv b (\mod n) \Rightarrow \left( \frac{a}{n} \right) = \left( \frac{b}{n} \right)$</li>
                          <li>$\left( \frac{1}{n} \right) = 1$</li>
                          <li>$\left( \frac{-1}{n} \right) = (-1)^{\frac{(n - 1)}{2}}$</li>
                          <li>$\left( \frac{2}{n} \right) = (-1)^{\frac{(n^2 - 1)}{8}}$</li>
                          <li>$\left( \frac{m}{n} \right) = \left( \frac{n}{m} \right) (-1)^{\frac{(m - 1)(n - 1)}{4}}$</li>
                        </ul>
                        Z własności symbolu Jacobiego wynika, że jeżeli $n$ nieparzyste oraz $a$ nieparzyste i w postaci $a = 2^e
                        a_1$,
                        gdzie $a_1$ też nieparzyste to:
                        $$\bigg( \frac{a}{n} \bigg) = \left( \frac{2^e}{n} \right) \bigg( \frac{a_1}{n} \bigg) = \left(
                        \frac{2}{n}
                        \right)^e \left( \frac{n \mod a_1}{a_1} \right) (-1)^{\frac{(a_1 - 1)(n - 1)}{4}}$$
                      </p>
                      <p>
                        <b>Algorytm obliczania symbolu Jacobiego $\left( \frac{a}{n} \right)$ (i Legendre'a)</b> dla nieparzystej
                        liczby
                        całkowitej $n \geqslant 3$ oraz całkowitego $0 \leqslant a < n$
                        <pre>JACOBI($a, n$)</pre>
                        <ol type='a'>
                          <li>
                            <pre>
                If $a = 0$ then return $0$</pre>
                          </li>
                          <li>
                            <pre>If $a = 1$ then return $1$</pre>
                          </li>
                          <li>
                            <pre>Write $a = 2^ea_1$, gdzie $a_1$ nieparzyste</pre>
                          </li>
                          <li>
                            <pre>If $e$ parzyste set $set \leftarrow 1$
                Otherwise set $s \leftarrow 1$ if $n \equiv 1 $ or $7 ($mod$8)$, or set
                $s \leftarrow -1$ if $n \equiv 3$ or $5 ($mod$8)$</pre>
                          </li>
                          <li>
                            <pre>If $n \equiv 3 ($mod$4)$ and $a_1 \equiv 3($mod$3)$ then set $s \leftarrow -s$</pre>
                          </li>
                          <li>
                            <pre>Set $n_1 \leftarrow n$mod$a_1$</pre>
                          </li>
                          <li>
                            <pre>If $a_1 = 1$ then return $s$
                Otherwise reurn $s \cdot$JACOBI($a_1, n_1$)</pre>
            </li>
          </ol>
          Algorytm działa w czasie $\mathcal{O}((\lg n)^2)$ operacji bitowych.
        </p>
      </section>

      <section id='shamir'>
        <header>
          <h2>Schemat progowy $(t, n)$ dzielenia sekretu Shamira</h2>
        </header>
        <p>
          <b>Cel:</b> Zaufana Trzecia Strona $T$ ma sekret $S \geqslant 0$, który chce podzielić pomiędzy $n$ uczestników
          tak,
          aby dowolnych $t$ spośród niech mogło sekret odtworzyć.
        </p>
        <p>
          <b>Faza inicjalizacji:</b>
          <ul>
            <li>$T$ wybiera liczbę pierwszą $p \ge max(S, n)$ i definiuje $a_0 = S$,</li>
            <li>$T$ wybiera losowo i niezależnie $t - 1$ współczynników $a_1, ..., a_{t-1} \in \mathbb{Z}_p$,</li>
            <li>$T$ definiuje wielomian nad $\mathbb{Z}_p$:
              $$f(x) = a_0 + \sum^{t-1}_{j = 1} a_jx^j,$$
            </li>
            <li>Dla $1 \leqslant i \leqslant n$ Zaufana Trzecia Strona $T$ wybiera losowo $x_i \in \mathbb{Z}_p$, oblicza:
              $S_i =
              f(x_i) \mod p$ i bezpiecznie przekazuje parę $(x_i, S_i)$ uzytkownikowi $P_i$.</li>
          </ul>
        </p>
        <p>
          <b>Faza łączenia udziałów w sekret:</b> Dowolna grupa $t$ lub więcej użytkowników łączy swoje udziały - $t$
          róznych punktów $(x_i, S_i)$ wielomianu $f$ i dzięki interpolacji Lagrange'a odzyskuje sekret $S = a_0 =
          f(0)$.
        </p>
      </section>

      <section id='lagrange'>
        <header>
          <h2>Interpolacja Lagrange'a</h2>
        </header>
        <p>
          Mając dane $t$ różnych punktów $(x_i, y_i)$ nienanego wielomianu $f$ stopnia mniejszego od $t$ możemy
          policzyć
          jego współczynniki korzystając ze wzoru:
          $$f(x) = \sum^t_{i = 1}\left( y_i \prod_{1 \leqslant j \leqslant t,\, j\neq i} \frac{x - x_j}{x_i - x_j} \right)
          \mod
          p$$
          <b>Wskazówka:</b> w schemacie Shamira, aby odzyskać sekret <i>S</i>, użytkownicy nie muszą znać całego
          wielomianu $f$. Wsstawiając do wzoru na iterpolację Lagrange'a $x = 0$, dostajemy wersję uproszczoną, ale
          wystarczającą aby policzyć sekret $S = f(0)$:
          $$f(x) = \sum^t_{i = 1} \left(y_i \prod_{1 \leqslant j \leqslant t,\, j\neq i} \frac{x_j}{x_j - x_i} \right)
          \mod p$$
        </p>
      </section>

      <section id="example">
        <header>
          <h2>Przykład</h2>
        </header>
        <h4>Inicjalizacja</h4>
        Niech sekret $S = 1234$. Dzielimy go między 6 osób $(n=6)$, z czego 3 będą mogły go zrekonstruować $(t=3)$.
        Losowo wybieramy $t-1=2$ liczb: $166$ i $94$. Wygenerowany wielomian jest zatem postaci:
        $$f(x) = 1234 + 166x +94x^2$$
        Wybieramy 6 punktów z wielomianu:
        $(1,1494), (2,1942), (3,2578), (4,3402), (5,4414), (6, 5614)$.
        <h4>Łączenie udziałów</h4>
        Z wcześniej wygenerowanych wybierzmy $t$ punktów, np: $(2,1942), (4,3402), (5,4414)$. Korzystamy ze wzoru:
        $$
        S = 1942\cdot \frac{4}{4-2} \cdot \frac{5}{5-2}
        + 3402\cdot \frac{5}{5-4} \cdot \frac{2}{2-4}
        + 4414\cdot \frac{2}{2-5} \cdot \frac{4}{4-5}
        =
        $$

        $$
        = 1942 \cdot \frac{10}{3} + 3402 \cdot (-5) + 4414 \cdot \frac{8}{3} =
        $$

        $$
        = 1234
        $$
      </section>

      <footer id="main-footer">
        <p>
          Odwiedziłeś tę stronę <b><?= $_COOKIE["counter"] ?: 1 ?></b> razy.
        </p>
        <small>
          Korzystając z tej strony, wyrarzasz zgodę na wykorzystanie plików cookies.
        </small>
        <small>
          © Copyright 2019 Paweł Rubin
        </small>
      </footer>
    </main>
  </body>
</html>