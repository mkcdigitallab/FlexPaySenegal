# FlexPaySenegal

Prototype pédagogique d'une application de portefeuille électronique adaptée au contexte sénégalais. Le projet illustre l'authentification, la séparation des espaces **client** et **agent**, l'affichage d'un portefeuille en FCFA (XOF) et la consultation de l'historique des transactions.

> **Important :** FlexPaySenegal est un prototype éducatif. Les formulaires de dépôt et de retrait de l'espace agent sont actuellement simulés dans Vue. Ils ne modifient ni le solde ni les transactions en base de données. N'utilisez pas ce projet pour gérer de l'argent réel.

## Sommaire

- [Fonctionnalités](#fonctionnalités)
- [Technologies](#technologies)
- [Architecture et parcours](#architecture-et-parcours)
- [Fichiers modifiés ou ajoutés](#fichiers-modifiés-ou-ajoutés)
- [Routes web](#routes-web)
- [Méthodes et logique principales](#méthodes-et-logique-principales)
- [Compte agent de démonstration](#compte-agent-de-démonstration)
- [Installation locale](#installation-locale)
- [État actuel et prochaines étapes](#état-actuel-et-prochaines-étapes)

## Fonctionnalités

- Page d'accueil présentant le prototype.
- Inscription d'un client avec nom, téléphone, e-mail facultatif et mot de passe.
- Connexion par téléphone et mot de passe, avec option « rester connecté ».
- Création automatique d'un portefeuille en XOF lors de l'inscription.
- Redirection vers un tableau de bord selon le rôle de l'utilisateur.
- Espace client : consultation du solde, du profil et de l'historique ; indication que les dépôts et retraits doivent être réalisés auprès d'un agent.
- Espace agent : interface de simulation d'un dépôt ou d'un retrait avec validation du téléphone et du montant.
- Historique des transactions et pagination lorsque les données sont fournies sous forme paginée.
- Compte agent de démonstration disponible uniquement en environnement local ou de test.

## Technologies

- **Laravel / PHP** : routes, contrôleurs, validation serveur, sessions et accès aux données.
- **Vue 3 + TypeScript** : pages et interactions de l'interface.
- **Inertia.js** : passage des données du serveur aux pages Vue et navigation.
- **Tailwind CSS** : styles de l'interface.
- **Eloquent ORM** : relations entre utilisateurs, portefeuilles et transactions.

## Architecture et parcours

### Parcours d'inscription

1. Le visiteur ouvre `/register`.
2. La page Vue envoie le formulaire à `POST /register`.
3. `AuthController::register()` valide les champs.
4. Dans une transaction de base de données, Laravel crée l'utilisateur avec le rôle `client`, puis son portefeuille initialisé à **0 XOF**.
5. L'utilisateur est connecté et sa session est régénérée.
6. Il est redirigé vers `/dashboard`. Le contrôleur choisit ensuite la page correspondant à son rôle.

### Parcours de connexion

1. Le visiteur ouvre `/login`.
2. La page Vue transmet le téléphone, le mot de passe et l'option « rester connecté ».
3. `AuthController::store()` valide les champs puis demande à Laravel d'authentifier l'utilisateur.
4. En cas d'échec, une erreur est renvoyée sur le champ téléphone. En cas de succès, la session est régénérée et l'utilisateur est redirigé vers le tableau de bord.

### Différence entre client et agent

- **Client :** consulte son propre portefeuille et son historique. Il ne dispose pas d'une action lui permettant de créditer lui-même son solde. Pour un dépôt ou un retrait, l'interface lui indique de passer par un agent.
- **Agent :** voit les outils de caisse destinés à préparer une opération. Dans la version actuelle, le formulaire valide les informations et affiche une confirmation de simulation ; il n'enregistre pas de transaction.

## Fichiers modifiés ou ajoutés

La comparaison de la branche `fix/authentication-and-transactions-page` avec `main` identifie **11 fichiers concernés : 5 ajoutés et 6 modifiés**. Les fichiers déjà présents et simplement réutilisés dans les nouvelles pages sont listés séparément.

### Fichiers ajoutés

| Fichier | Rôle |
|---|---|
| `app/Http/Controllers/AuthController.php` | Regroupe les actions d'affichage de connexion, d'authentification, d'affichage du formulaire d'inscription, de création de compte et de déconnexion. |
| `resources/js/pages/Auth/Login.vue` | Formulaire de connexion, option « rester connecté », affichage des erreurs et remplissage des identifiants de démonstration lorsqu'ils sont fournis par le serveur. |
| `resources/js/pages/Auth/Register.vue` | Formulaire d'inscription avec nom, téléphone, e-mail facultatif, mot de passe et confirmation. |
| `resources/js/pages/Client/Dashboard.vue` | Tableau de bord dédié au client : solde, profil, dernières transactions et explication du parcours dépôt/retrait via un agent. |
| `resources/js/pages/Dashboard.vue` | Tableau de bord agent, formulaires de simulation dépôt/retrait, validation côté interface et affichage du portefeuille et de l'historique. |

### Fichiers modifiés

| Fichier | Rôle et changements |
|---|---|
| `app/Http/Controllers/DashboardController.php` | Récupère l'utilisateur connecté, son portefeuille et ses cinq transactions les plus récentes ; choisit le tableau de bord client ou agent selon le rôle. |
| `database/factories/UserFactory.php` | Génère notamment un numéro de téléphone sénégalais de test unique commençant par 7, pour les utilisateurs créés par les factories. |
| `database/seeders/DatabaseSeeder.php` | Crée ou met à jour le compte agent de démonstration uniquement en local/test et lui assure un portefeuille sans réinitialiser le solde lors d'une nouvelle exécution. |
| `resources/js/pages/Transactions/Index.vue` | Affiche la liste des transactions et prend en charge les données sous forme de tableau simple ou de résultat paginé. |
| `resources/js/pages/Welcome.vue` | Présente la page d'accueil et oriente vers la connexion ou la création de compte ; indique clairement le caractère éducatif du prototype. |
| `routes/web.php` | Déclare les routes publiques, les routes réservées aux visiteurs non connectés et les routes protégées par authentification. Les formulaires de connexion et d'inscription sont limités à six tentatives par minute. |

### Composants et types réutilisés

Ces fichiers sont utilisés par les pages, mais ne font pas partie des 11 fichiers modifiés dans la comparaison mentionnée plus haut.

| Fichier | Responsabilité |
|---|---|
| `resources/js/components/wallet/BalanceCard.vue` | Affiche le solde du portefeuille. |
| `resources/js/components/wallet/TransactionList.vue` | Affiche une liste de transactions. |
| `resources/js/types/wallet.ts` | Définit les types TypeScript utilisés pour les utilisateurs, portefeuilles et transactions. |
| `resources/js/utils/currency.ts` | Fournit le formatage des montants en monnaie, notamment en FCFA. |

## Routes web

Les routes suivantes sont déclarées dans `routes/web.php`.

| Méthode HTTP | URL | Nom Laravel | Accès | Utilité |
|---|---|---|---|---|
| GET | `/` | `home` | Public | Affiche la page d'accueil. |
| GET | `/login` | `login` | Visiteur non connecté | Affiche le formulaire de connexion. |
| POST | `/login` | `login.store` | Visiteur non connecté | Vérifie les identifiants et ouvre la session. Limitation : 6 requêtes/minute. |
| GET | `/register` | `register` | Visiteur non connecté | Affiche le formulaire d'inscription. |
| POST | `/register` | `register.store` | Visiteur non connecté | Crée un compte client et son portefeuille. Limitation : 6 requêtes/minute. |
| POST | `/logout` | `logout` | Connecté | Ferme la session. |
| GET | `/dashboard` | `dashboard` | Connecté | Affiche le tableau de bord correspondant au rôle. |
| GET | `/wallet` | `wallet.show` | Connecté | Affiche les détails du portefeuille via `WalletController`. |
| GET | `/transactions` | `transactions.index` | Connecté | Affiche l'historique via `TransactionController`. |

Les routes `/wallet` et `/transactions` sont raccordées à des contrôleurs dédiés. Les six fichiers listés comme modifiés ou ajoutés ci-dessus ne signifient pas que ces contrôleurs ou les modèles correspondants ont été modifiés dans cette branche.

## Méthodes et logique principales

### `AuthController.php`

#### `create(): Response`

- Affiche la page Inertia `Auth/Login`.
- Fournit les identifiants de démonstration uniquement lorsque l'application tourne en environnement `local`.
- Renvoie `null` pour ces identifiants dans les autres environnements.

#### `store(Request $request): RedirectResponse`

- Valide la présence du téléphone et du mot de passe.
- Utilise `Auth::attempt()` pour vérifier les identifiants.
- En cas d'échec, retourne au formulaire avec un message d'erreur et conserve le téléphone saisi.
- En cas de succès, régénère la session et redirige vers la route `dashboard`.

#### `showRegistrationForm(): Response`

Affiche la page Inertia `Auth/Register`.

#### `register(Request $request): RedirectResponse`

- Valide le nom, le téléphone unique, l'e-mail facultatif et le mot de passe confirmé d'au moins huit caractères.
- Utilise `DB::transaction()` pour que la création de l'utilisateur et celle du portefeuille soient réalisées ensemble.
- Crée le compte avec le rôle `client`.
- Crée un portefeuille avec un solde de `0` et la devise `XOF`.
- Connecte automatiquement le nouvel utilisateur, régénère la session puis redirige vers le tableau de bord.

#### `destroy(Request $request): RedirectResponse`

- Déconnecte l'utilisateur avec `Auth::logout()`.
- Invalide la session et régénère le jeton CSRF.
- Redirige vers la page d'accueil.

### `DashboardController.php`

#### `index(Request $request): Response`

- Récupère l'utilisateur authentifié à partir de la requête.
- Récupère son portefeuille.
- Si le portefeuille existe, charge ses cinq transactions les plus récentes ; sinon, transmet une collection vide.
- Transmet à Inertia les informations utiles de l'utilisateur (`id`, `name`, `phone`, `role`), le portefeuille et les transactions.
- Affiche `Client/Dashboard` si le rôle est `client`, sinon `Dashboard`.

### `Login.vue`

#### `submit()`

Envoie les valeurs du formulaire à `POST /login` avec Inertia. Le serveur reste responsable de la validation et de l'authentification.

#### `fillDemoCredentials()`

Si les identifiants de démonstration ont été transmis par le serveur, les copie dans les champs du formulaire. Cette fonction ne se connecte pas automatiquement.

### `Register.vue`

#### `submit()`

Envoie le formulaire à `POST /register`. La validation serveur est effectuée dans `AuthController::register()` ; la validation visuelle HTML ne remplace pas cette validation.

### `Client/Dashboard.vue`

#### `logout()`

Envoie une requête POST à `/logout` pour fermer la session.

La page utilise aussi `BalanceCard` pour le solde et `TransactionList` pour les opérations récentes. Elle ne propose pas de bouton permettant au client de modifier directement son solde.

### `Dashboard.vue` — espace agent

#### `openOperation(type: OperationType)`

Ouvre le formulaire de dépôt ou de retrait, vide les anciennes valeurs et réinitialise les erreurs et le message de confirmation.

Les valeurs possibles de `type` sont `deposit` et `withdrawal`.

#### `closeOperation()`

Ferme la fenêtre de l'opération et efface les erreurs affichées.

#### `validateOperation(): boolean`

Vérifie les champs avant la simulation :

- Le téléphone doit contenir exactement neuf chiffres et commencer par `7` (`/^7\\d{8}$/`).
- Le montant doit être renseigné, numérique et strictement supérieur à zéro.
- Le montant doit être un nombre entier, car il est exprimé en FCFA.

La fonction renvoie `true` si aucune erreur n'a été détectée, sinon `false`.

#### `submitOperation()`

- Lance la validation.
- Si le formulaire est invalide, arrête le traitement.
- Sinon, prépare un message indiquant l'opération simulée, le numéro et le montant formaté.
- Ferme ensuite le formulaire.

**Limite importante :** cette méthode ne fait aucun appel à un endpoint de dépôt ou de retrait. Elle ne modifie ni le solde ni l'historique en base de données.

#### `logout()`

Envoie une requête POST à `/logout`.

#### `operationTitle`

Propriété calculée qui affiche « Nouveau dépôt » lorsque le type actif est `deposit`, et « Nouveau retrait » dans l'autre cas.

### `DatabaseSeeder.php`

#### `run(): void`

- Quitte immédiatement si l'environnement n'est ni `local` ni `testing`.
- Utilise `User::updateOrCreate()` pour créer ou mettre à jour le compte agent repéré par son téléphone.
- Utilise `firstOrCreate()` pour lui assurer un portefeuille en XOF avec un solde initial de zéro.
- Ne remet pas le solde à zéro si le portefeuille existe déjà.

### `UserFactory.php`

#### `definition(): array`

Fournit les attributs par défaut d'un utilisateur de test : nom fictif, téléphone unique commençant par 7, e-mail, date de vérification, mot de passe haché et jeton de session.

#### `unverified(): static`

Retourne un état de factory où `email_verified_at` vaut `null`, pour créer un utilisateur dont l'e-mail n'est pas vérifié.

### `Transactions/Index.vue`

La page reçoit les transactions via `defineProps`. Elle accepte soit un tableau, soit un objet paginé :

- Pour un tableau, elle affiche directement les éléments.
- Pour un objet paginé, elle affiche `transactions.data`.
- Si plusieurs pages existent, elle construit les liens de pagination à partir de `current_page` et `last_page`.

### `Welcome.vue`

Page d'accueil publique qui présente brièvement FlexPay et propose les liens vers la connexion et l'inscription. Elle rappelle que les opérations affichées sont un prototype et qu'aucun mouvement d'argent réel n'est réalisé.

## Compte agent de démonstration

Le seeder local/test prépare ce compte :

- **Téléphone :** `770000001`
- **Mot de passe :** `AgentDemo2026!`
- **Rôle :** `agent`
- **Solde initial :** `0 XOF`

La page de connexion ne reçoit et n'affiche ces identifiants que dans l'environnement local. Ne réutilisez pas ce compte en production et ne publiez jamais des identifiants prévisibles pour un environnement réel.

Pour exécuter le seeder dans votre environnement local :

```bash
php artisan db:seed
```

## Installation locale

Les commandes ci-dessous correspondent à un projet Laravel avec dépendances PHP et JavaScript déjà déclarées dans le dépôt. Configurez d'abord votre fichier `.env` avec les paramètres de votre base de données.

```bash
# Installer les dépendances PHP
composer install

# Installer les dépendances JavaScript
npm install

# Préparer la configuration locale
cp .env.example .env
php artisan key:generate
```

Après avoir configuré la base de données dans `.env` :

```bash
php artisan migrate
php artisan db:seed
```

Lancer ensuite Laravel et Vite dans deux terminaux distincts :

```bash
php artisan serve
```

```bash
npm run dev
```

Ouvrez l'adresse locale indiquée par Laravel dans votre navigateur. Si le dépôt utilise déjà une configuration locale ou des conteneurs Docker, suivez en priorité les consignes correspondantes du projet.

## État actuel et prochaines étapes

### Déjà présent dans cette version

- Authentification par téléphone et mot de passe.
- Inscription des clients et création de portefeuille en XOF.
- Tableau de bord distinct selon le rôle.
- Lecture du solde et des transactions existantes.
- Validation de formulaire côté agent pour la simulation.
- Compte agent de démonstration limité aux environnements local/test.

### À réaliser avant toute vraie opération financière

1. Ajouter des endpoints serveur dédiés aux dépôts et retraits.
2. Valider à nouveau toutes les données côté Laravel ; ne jamais faire confiance à la validation Vue seule.
3. Retrouver le client depuis son numéro et vérifier son identité selon les règles métier.
4. Implémenter les mouvements de solde et la création de transaction dans une transaction de base de données.
5. Définir précisément les règles de dépôt/retrait, notamment la disponibilité des fonds, les limites, les erreurs et les opérations concurrentes.
6. Vérifier les autorisations côté serveur pour empêcher un client d'utiliser les actions réservées aux agents.
7. Ajouter des tests automatisés couvrant l'authentification, les rôles, les validations et les mouvements de solde.
8. Protéger les données sensibles, configurer les environnements de production et faire auditer la sécurité avant toute utilisation réelle.

---

**Branche documentée :** `fix/authentication-and-transactions-page`  
**Statut :** documentation du prototype actuel, sans prétendre que les dépôts/retraits simulés sont persistés.
