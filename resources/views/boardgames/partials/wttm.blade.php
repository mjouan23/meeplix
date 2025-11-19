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
<div class="decks">
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
    <a href="#" class="btn btn-primary" id="pullButton">Tirer</a>
    <a href="{{ url('/') }}" class="btn btn-secondary">Retour</a>
</div>
