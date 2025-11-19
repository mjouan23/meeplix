<div class="scenarios">
    <select name="lstScenarios" class="lstScenarios">
        <option value="1">Aventure 1 : Le décollage</option>
        <option value="2">Aventure 2 : Le voyage</option>
        <option value="3">Aventure 3 : La colonie</option>
        <option value="4">Aventure 4 : La mine</option>
        <option value="5">Aventure 5 :  Le dôme</option>
        <option value="6">Aventure 6 : Le virus</option>
        <option value="7">Aventure 7 :  La fuite</option>
        <option value="8">Aventure 8 : L'affrontement</option>
    </select>
    <a href="#" class="btn btn-primary" id="playButton">Jouer !</a>
</div>
<div class="objectives">
    <img class="img-objective-card objective-a">
    <img class="img-objective-card objective-b">
    <img class="img-objective-card objective-c">
</div>
<div class="wttm-loader" aria-hidden="true">
    <svg width="140" height="140" viewBox="0 0 140 140" xmlns="http://www.w3.org/2000/svg">
        <circle cx="70" cy="70" r="60" stroke="#115E89" stroke-width="5" fill="none" opacity="0.25"></circle>
        <circle cx="70" cy="70" r="60" stroke="#26A9E0" stroke-width="7" fill="none" stroke-linecap="round" stroke-dasharray="90 400">
            <animateTransform attributeName="transform" type="rotate" from="0 70 70" to="360 70 70" dur="1.6s" repeatCount="indefinite"></animateTransform>
        </circle>
    </svg>
</div>
<div class="decks is-hidden">
    <section class="deck" data-deck="0">
        <div class="zones">
            <div>
                <img class="img-next-action icon-action-1">
                <img class="img-next-action icon-action-2">
                <img class="img-next-number">
            </div>
            <div>
                <img class="img-last-action">
            </div>
        </div>
    </section>

    <section class="deck" data-deck="1">
        <div class="zones">
            <div>
                <img class="img-next-action icon-action-1">
                <img class="img-next-action icon-action-2">
                <img class="img-next-number">
            </div>
            <div>
                <img class="img-last-action">
            </div>
        </div>
    </section>

    <section class="deck" data-deck="2">
        <div class="zones">
            <div>
                <img class="img-next-action icon-action-1">
                <img class="img-next-action icon-action-2">
                <img class="img-next-number">
            </div>
            <div>
                <img class="img-last-action">
            </div>
        </div>
    </section>
</div>
<div class="action-buttons">
    <a href="#" class="btn btn-primary is-invisible" id="pullButton">Tirer</a>
    <a href="{{ url('/') }}" class="btn btn-secondary">Retour</a>
</div>
