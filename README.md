# Book Manager

BiblioTech is a simple CRUD application for managing books and authors, built with Symfony 7.4.

## 🚀 Features
* **Book Management**: Create, edit and delete books.
* **Author Management**: Create, edit and delete authors.
* **UI Components**: Reusable Bootstrap modals.
* **Validation**: Built-in form validation.
* **Feedback**: Real-time toast notifications.
* **Masks**: Currency mask for book prices.
* **Internationalization**: Full translation support (i18n).
* **Responsive**: Interface adapts to any screen.

## 🛠️ Technologies
* **Language**: PHP 8+
* **Framework**: Symfony 7.4
* **Database ORM**: Doctrine ORM
* **Template Engine**: Twig
* **Frontend**: Bootstrap 5 & JavaScript
* **Database**: MySQL

## 💻 Installation

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   ```

2. **Access the project folder:**
   ```bash
   cd bibliotech
   ```

3. **Install dependencies:**
   ```bash
   composer install
   ```

4. **Configure environment:**
    * Open the `.env` file.
    * Update it with your database credentials.

5. **Run migrations:**
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

6. **Start the local server:**
   ```bash
   symfony server:start
   ```

## 📁 Project Structure

```text
src/
├── Controller/
├── Entity/
├── Form/
└── Repository/

templates/
├── book/
├── author/
└── components/

assets/
├── js/
└── styles/
```

## 👤 Author
Developed by **Raylan Cordeiro**.
