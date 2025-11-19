// === Données : 63 cartes ===
  const lstCards = [
    [1,'robot'], [1,'energie'], [2,'robot'], [2,'plante'], [3,'eau'], [3,'astronaute'], [3,'planning'],
    [4,'astronaute'], [4,'energie'], [4,'plante'], [4,'planning'], [5,'energie'], [5,'energie'], [5,'robot'],
    [5,'robot'], [5,'plante'], [6,'energie'], [6,'planning'], [6,'plante'], [6,'robot'], [6,'astronaute'],
    [6,'eau'], [7,'eau'], [7,'energie'], [7,'robot'], [7,'plante'], [7,'plante'], [7,'energie'],
    [8,'eau'], [8,'plante'], [8,'astronaute'], [8,'robot'], [8,'planning'], [8,'robot'], [8,'plante'],
    [9,'robot'], [9,'eau'], [9,'energie'], [9,'energie'], [9,'plante'], [9,'plante'], [10,'astronaute'],
    [10,'robot'], [10,'planning'], [10,'plante'], [10,'energie'], [10,'eau'], [11,'energie'], [11,'plante'],
    [11,'robot'], [11,'energie'], [11,'robot'], [12,'energie'], [12,'planning'], [12,'astronaute'],
    [12,'plante'], [13,'eau'], [13,'astronaute'], [13,'planning'], [14,'plante'], [14,'robot'],
    [15,'robot'], [15,'energie']
  ];

  // === Utilitaires ===
  // Résolution d'URLs via Vite (dev/prod) avec import.meta.glob
  // Note: dossier correct = "numbers" (et non "nombres")
  const NUMBER_URLS = import.meta.glob('../../images/boardgames/wttm/numbers/*.webp', {
    as: 'url',
    eager: true,
  });
  const ACTION_URLS = import.meta.glob('../../images/boardgames/wttm/actions/*.webp', {
    as: 'url',
    eager: true,
  });
  const ICON_URLS = import.meta.glob('../../images/boardgames/wttm/icons/*.webp', {
    as: 'url',
    eager: true,
  });
  const OBJECTIVE_URLS = import.meta.glob('../../images/boardgames/wttm/objectives/*.webp', {
    as: 'url',
    eager: true,
  });

  function shuffle(array) {
    const arr = array.slice();
    for (let i = arr.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [arr[i], arr[j]] = [arr[j], arr[i]];
    }
    return arr;
  }

  function splitInThree(shuffled) {
    return [shuffled.slice(0, 21), shuffled.slice(21, 42), shuffled.slice(42, 63)];
  }

  // État des paquets
  let decks = []; // Array of { cards: [ [number, action], ...], index: number, lastAction: string|null }
  function initDecks() {
    const shuffled = shuffle(lstCards);
    const parts = splitInThree(shuffled);
    decks = parts.map(cards => ({ cards, index: 0, lastAction: null }));
  }

  function imgNumberSrc(n) {
    const key = `../../images/boardgames/wttm/numbers/nombre-${n}.webp`;
    return NUMBER_URLS[key] ?? '';
  }
  function imgActionSrc(action) {
    const key = `../../images/boardgames/wttm/actions/action-${action}.webp`;
    return ACTION_URLS[key] ?? '';
  }
  function imgIconSrc(action) {
    const key = `../../images/boardgames/wttm/icons/icon-${action}.webp`;
    return ICON_URLS[key] ?? '';
  }

  // Objectives helpers
  function randomVariant() {
    return Math.random() < 0.5 ? 1 : 2; // 1 ou 2
  }
  function imgObjectiveSrc(letter, scenario, variant) {
    const key = `../../images/boardgames/wttm/objectives/objective-${letter}-${scenario}-${variant}.webp`;
    return OBJECTIVE_URLS[key] ?? '';
  }
  function renderObjectivesForScenario(scenarioValue) {
    const scenario = parseInt(scenarioValue, 10);
    if (!Number.isFinite(scenario)) return;
    ['a','b','c'].forEach(letter => {
      const variant = randomVariant();
      let src = imgObjectiveSrc(letter, scenario, variant);
      // Fallback: si non trouvé, tenter l'autre variante
      if (!src) {
        const altVariant = variant === 1 ? 2 : 1;
        src = imgObjectiveSrc(letter, scenario, altVariant);
      }
      const imgEl = document.querySelector(`.img-objective-card.objective-${letter}`);
      if (imgEl && src) {
        imgEl.src = src;
        imgEl.alt = `Objectif ${letter.toUpperCase()} - Scénario ${scenario}`;
      }
    });
  }

  function renderDeck($deck) {
    const deckId = parseInt($deck.dataset.deck, 10);
    const state = decks[deckId];
    const nextNumberImg = $deck.querySelector('.img-next-number');
    const nextActionImgs = $deck.querySelectorAll('.img-next-action');
    const lastActionImg = $deck.querySelector('.img-last-action');

    // Si le paquet est vide, on le re-mélange immédiatement (séparément)
    if (state.index >= state.cards.length) {
      state.cards = shuffle(state.cards);
      state.index = 0;
      // on garde state.lastAction tel quel pour l'affichage
    }

    // Prochain nombre (peek)
    if (state.index < state.cards.length) {
      const [nextNumber, nextAction] = state.cards[state.index];
      nextNumberImg.src = imgNumberSrc(nextNumber);
      nextNumberImg.style.opacity = '1';
      nextNumberImg.alt = `Prochain nombre: ${nextNumber}`;
      nextActionImgs.forEach(img => {
        const iconSrc = imgIconSrc(nextAction);
        if (iconSrc) {
          img.src = iconSrc;
          img.alt = `Action associee: ${nextAction}`;
          img.style.opacity = '1';
        } else {
          img.removeAttribute('src');
          img.alt = 'Action inconnue';
          img.style.opacity = '0.4';
        }
      });
    } else {
      // Plus de cartes
      nextNumberImg.removeAttribute('src');
      nextNumberImg.alt = 'Fin du paquet';
      nextNumberImg.style.opacity = '0.4';
      nextActionImgs.forEach(img => {
        img.removeAttribute('src');
        img.alt = 'Fin du paquet';
        img.style.opacity = '0.4';
      });
    }

    // Dernière action piochée
    if (state.lastAction) {
      lastActionImg.src = imgActionSrc(state.lastAction);
      lastActionImg.style.opacity = '1';
      lastActionImg.alt = `Dernière action: ${state.lastAction}`;
    } else {
      lastActionImg.removeAttribute('src');
      lastActionImg.alt = 'Aucune pioche pour le moment';
      lastActionImg.style.opacity = '0.4';
    }

    // Compteur
    const restants = state.cards.length - state.index;
  }

  function drawFromDeck(deckId) {
    const state = decks[deckId];
    if (state.index >= state.cards.length) return; // plus rien à piocher
    const [, action] = state.cards[state.index];
    state.lastAction = action;
    state.index += 1;
  }

  function resetDeck(deckId) {
    // On re-mélange TOUT puis on redistribue — pour garder la règle des 3 paquets qui couvrent les 63 cartes.
    initDecks();
  }

  // Initialisation UI
  (function mount() {
    initDecks();
    
    document.querySelectorAll('#boardgame-wttm .deck').forEach($deck => {
        // Premier rendu
        renderDeck($deck);
    });

    // Listeners
    const scenarios = document.querySelector('.scenarios');
    const objectives = document.querySelector('.objectives');
    const scenarioSelect = document.querySelector('.lstScenarios');
    const playButton = document.querySelector('#playButton');
    const loader = document.querySelector('#boardgame-wttm .wttm-loader');
    const decksWrapper = document.querySelector('#boardgame-wttm .decks');
    if (playButton && scenarioSelect) {
      playButton.addEventListener('click', (e) => {
        e.preventDefault();
        // 1) Tirage aléatoire des objectifs en fonction du scénario choisi
        renderObjectivesForScenario(scenarioSelect.value);
        // 2) Premier tirage des cartes numbers pour révéler les 3 premières actions
        decks.forEach((_, i) => drawFromDeck(i));
        // 3) Re-render des 3 paquets
        document.querySelectorAll('#boardgame-wttm .deck').forEach(renderDeck);
        scenarios.style.display = 'none';
        objectives.style.display = 'flex';
        if (loader) loader.classList.add('is-hidden');
        if (decksWrapper) decksWrapper.classList.remove('is-hidden');
      });
    }
    const btnPull = document.querySelector('#pullButton');
    if (btnPull) {
        btnPull.addEventListener('click', () => {
            // Tour: on pioche 1 carte dans chacun des 3 paquets
            decks.forEach((_, i) => drawFromDeck(i));
            // Puis on re-render les 3 paquets
            document.querySelectorAll('#boardgame-wttm .deck').forEach(renderDeck);
        });
    }
  })();
