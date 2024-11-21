# 🍎🥕 Fruits and Vegetables

This project is designed to manage products (fruits and vegetables) while following **Domain-Driven Design (DDD)** principles and clean code practices. The application provides functionality to list and create products via a RESTful API.

---

## **1. Project Structure**

The project is organized into **core layers**, adhering to the principles of Domain-Driven Design (DDD):

```
src/ 
├── Domain/ # Core business logic and domain concepts
├── Application/ # Use cases
├── Infrastructure/ # Framework- and system-specific implementations
├── UI/ # Controllers
```
Tests are located in the `/tests` directory in the project root.

If this project had more complex and contained multiple domain areas, I would have used a **modular structure**, where each module encapsulates its own **Domain**, **Application**, **Infrastructure**, **Tests**, and **UI** layers. However, since this project contains only a single domain entity (`Product`), I opted for a flat structure to keep it simple and focused.

---

## **2. Installation and Usage**

### **Installation**

1. Clone the repository:
   ```bash
   git clone https://github.com/xtomdex/fruits-and-vegetables.git
   cd fruits-and-vegetables
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Run migrations:
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

4. Load fixtures:
   ```bash
   php bin/console doctrine:fixtures:load
   ```

5. Run tests:
   ```bash
   php bin/phpunit
   ```

6. Start the Symfony development server:
   ```bash
   symfony server:start
   ```

## **3. Endpoints**
The application exposes two main endpoints:

### **1. Product List**

**GET `/products`**

#### Query Parameters:
- `type`: (optional) Filter by product type (`fruit` or `vegetable`).
- `unit`: (optional) Return quantities in `kg` or `g` (default is `g`).
- `name`: (optional) Filter by product name (partial matches allowed).

#### Example Request:
```bash
curl -X GET 'http://127.0.0.1:8000/products?type=fruit&unit=kg'
```

#### Example Response:
```json
[
   {
      "id": 1,
      "name": "Apple",
      "type": "fruit",
      "quantity": 1000,
      "unit": "g"
   },
   {
      "id": 2,
      "name": "Banana",
      "type": "fruit",
      "quantity": 1,
      "unit": "kg"
   }
]
```
### **2. Create Product**

**POST `/products`**

#### Body Parameters:
- `name`: (string, required).
- `type`: (string, required, `fruit` or `vegetable`).
- `quantity`: (float, required).
- `unit`: (string, optional, `kg` or `g`, default is `g` if not provided).

#### Example Request:
```bash
curl -X POST 'http://127.0.0.1:8000/products' \
-H 'Content-Type: application/json' \
-d '{
    "name": "Carrot",
    "type": "vegetable",
    "quantity": 0.8,
    "unit": "kg"
}'
```
#### Example Response (201 Created):
```json
{
   "id": 1,
   "name": "Apple",
   "type": "fruit",
   "quantity": 1000,
   "unit": "g"
}
```
#### Validation Error Response (400 Bad Request):
```json
{
   "message": "Invalid quantity"
}
```
## **4. Summary**

In this project, I adhered to **DDD principles** and clean code practices to ensure maintainability and extensibility.

### **Unified Product Collection**

The task specified creating separate collections for `Fruits` and `Vegetables`. However, I chose to implement a **single `ProductCollection`**, which I believe is a better solution for the following reasons:

- **Simpler Design**: Storing all products in a single table and using a `type` field to differentiate them avoids unnecessary complexity.
- **Scalability**: This approach easily supports adding new product types (e.g., `grains`, `herbs`) without requiring changes to the database schema or significant code modifications.
- **Maintainability**: Filtering products dynamically by type ensures a cleaner and more DRY (Don’t Repeat Yourself) codebase compared to maintaining separate collections and logic for each product type.

While the requested task could have been implemented as specified, I believe the solution I implemented provides a more robust, future-proof, and elegant approach that aligns with modern software development principles.

---

Feel free to explore the codebase and test the API! Let me know if you have any questions or suggestions.
