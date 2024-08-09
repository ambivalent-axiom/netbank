<h1 align="center">Mocking Netbank with Crypto Trading</h1>
<h2 align="center">Codelex Final project</h2>

<p align="center">

This is a Codelex bootcamp final project by ambax/Artūrs Melnis.

Net-bank features user creation and logging. You can both create private or business user entity. Users can create and share cashing accounts between each other.
Accounts can have different main currency. Users can be assigned as contacts within the system. Contacts can send money to each other by selecting the contact in send money view.
Transfer values where sent currency differs from received currency are being exchanged based on Latvian Bank currency rate API.
Users can have an investment account to use with crypto investent feature. Crypto investment feature uses CoinMarkerCap as primary API and CoinPaprika as alternative API.
Users can buy, sell crypto, see their portfolio current value and % of profit or loss.
</p>

<h3>An overview of logged in Dashboard</h3>
<img src="/readme/dashboard.png"/>

<h3>An overview of accounts section</h3>
<img src="/readme/accounts.png"/>

<h3>An overview of transactions section with opened transaction detail modal</h3>
<img src="/readme/transactions.png"/>

<h3>An overview of crypto section</h3>
<img src="/readme/crypto.png"/>

<h3>An overview of crypto portfolio section</h3>
<img src="/readme/portfolio.png"/>


<h2 align="center">Requirements</h2>
<p>PHP > 8.2</p>
<p>Laravel > 11.9</p>
<p>node > v22.4.1</p>
<p>ext-http</p>

<h2 align="center">Setup</h2>

- ```git clone https://github.com/ambivalent-axiom/netbank.git```
- update .env.example and store as .env
- ```composer install```
- ```php artisan migrate```
- ```php artisan serv```
- ```php artisan key:generate```
- ```npm install```
- ```npm run build```
- Open ```localhost:8000``` in web browser.

<h2 align="center">Commands</h2>
<h3>Required:</h3>
- ```php artisan db:seed``` Populate database with some example data<br>
- ```php artisan app:fetch-fiat``` Retrieve currency data from LV Bank API:<br>
- ```php artisan app:fetch-crypto``` Retrieve currency data from crypto APIs:
 
<h3>Optional:</h3>
- ```php artisan app:fetch-crypto-info``` Retrieve currency logos from CoinMarketCap API<br>
- ```php artisan app:fetch-news``` Retrieve latest articles from NewsAPI<br>

<h2 align="center">.ENV</h2>
<p>Make sure to add Your CoinMarketCap API key to COINMC value. App can work without API key by utilizing CoinPaprika as failsafe method. However in order to load crypto logo images, You must use CoinMarketCap API.</p>
<p>For News to work You need to add NewsAPI key to NEWSAPI variable. You can obtain one from <a href="https://newsapi.org/">https://newsapi.org/</a></p>

-- END of readme.md --
