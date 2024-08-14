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


<img src="/readme/netbank.gif"/>

<h2 align="center">Requirements</h2>
<p>PHP > 8.2</p>
<p>Composer > v2.7.7</p>
<p>Node.js > v22.4.1</p>
<p>ext-http</p>

<h2 align="center">Setup</h2>

- ```git clone https://github.com/ambivalent-axiom/netbank.git``` Clone the Repository
- Set Up Environment File: update .env.example and store as .env | set postgresql for docker or sqlite for local development environment
- ```composer install``` Install PHP Dependencies
- ```php artisan key:generate``` Generate Application Key
- ```php artisan migrate``` Launch migration to create schemas
- ```npm install``` Install Frontend Dependencies
- ```npm run build``` Build Frontend
- ```php artisan serv``` Serve the Application
- Open ```localhost:8000``` in web browser.

<h2 align="center">Commands</h2>
<h3>Required:</h3>

- ```php artisan app:fetch-fiat``` Retrieve currency data from LV Bank API:<br>
- ```php artisan app:fetch-crypto``` Retrieve currency data from crypto APIs:
 
<h3>Optional:</h3>

- ```php artisan db:seed``` Populate database with some example data<br>

Seeder will create 2 DEMO users:
artmelnis@gmail.com & evelina.melne@gmail.com
with the same Pass: qwerty123

- ```php artisan app:fetch-crypto-info``` Retrieve currency logos from CoinMarketCap API<br>
- ```php artisan app:fetch-news``` Retrieve latest articles from NewsAPI<br>

<h2 align="center">.ENV</h2>
<p>Make sure to add Your CoinMarketCap API key to COINMC value. App can work without API key by utilizing CoinPaprika as failsafe method. However in order to load crypto logo images, You must use CoinMarketCap API.</p>
<p>For News to work You need to add NewsAPI key to NEWSAPI variable. You can obtain one from <a href="https://newsapi.org/">https://newsapi.org/</a></p>

<h2 align="center">Tests</h2>

Automated testing is done by using Pest. Run all feature tests with command:
- ```./vendor/bin/pest```


<h2 align="center">Contact</h2>
If you have any questions or feedback, feel free to reach out:<br>
Email: artmelnis@gmail.com
