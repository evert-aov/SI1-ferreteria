-- =========================================================
-- SCRIPT DE CREACIÓN DE BASE DE DATOS - SISTEMA FERRETERÍA
-- PostgreSQL Database Schema
-- Generado a partir de migraciones Laravel
-- =========================================================

-- ==========================================
-- 1. TABLAS DE SISTEMA Y AUTENTICACIÓN
-- ==========================================

-- Tabla: users
CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    phone VARCHAR(255),
    gender VARCHAR(10) NOT NULL CHECK (gender IN ('male', 'female')),
    address VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    document_type VARCHAR(10) DEFAULT 'CI' CHECK (document_type IN ('CI', 'NIT', 'PASSPORT')),
    document_number VARCHAR(255) UNIQUE NOT NULL,
    status BOOLEAN DEFAULT TRUE,
    email_verified_at TIMESTAMP,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Tabla: password_reset_tokens
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP
);

-- Tabla: sessions
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload TEXT NOT NULL,
    last_activity INTEGER NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE INDEX sessions_user_id_index ON sessions(user_id);
CREATE INDEX sessions_last_activity_index ON sessions(last_activity);

-- ==========================================
-- 2. TABLAS DE CACHÉ Y TRABAJOS
-- ==========================================

-- Tabla: cache
CREATE TABLE cache (
    key VARCHAR(255) PRIMARY KEY,
    value TEXT NOT NULL,
    expiration INTEGER NOT NULL
);

-- Tabla: cache_locks
CREATE TABLE cache_locks (
    key VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INTEGER NOT NULL
);

-- Tabla: jobs
CREATE TABLE jobs (
    id BIGSERIAL PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload TEXT NOT NULL,
    attempts SMALLINT NOT NULL,
    reserved_at INTEGER,
    available_at INTEGER NOT NULL,
    created_at INTEGER NOT NULL
);

CREATE INDEX jobs_queue_index ON jobs(queue);

-- Tabla: job_batches
CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INTEGER NOT NULL,
    pending_jobs INTEGER NOT NULL,
    failed_jobs INTEGER NOT NULL,
    failed_job_ids TEXT NOT NULL,
    options TEXT,
    cancelled_at INTEGER,
    created_at INTEGER NOT NULL,
    finished_at INTEGER
);

-- Tabla: failed_jobs
CREATE TABLE failed_jobs (
    id BIGSERIAL PRIMARY KEY,
    uuid VARCHAR(255) UNIQUE NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================
-- 3. TABLAS DE TIPOS DE USUARIO
-- ==========================================

-- Tabla: employees
CREATE TABLE employees (
    user_id BIGINT PRIMARY KEY,
    salary DECIMAL(10, 2) NOT NULL,
    hire_date DATE NOT NULL,
    termination_date DATE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabla: suppliers
CREATE TABLE suppliers (
    user_id BIGINT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    main_contact VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    commercial_terms TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabla: customers
CREATE TABLE customers (
    user_id BIGINT PRIMARY KEY,
    type VARCHAR(20) DEFAULT 'individual' CHECK (type IN ('individual', 'company')),
    credit_limit DECIMAL(10, 2),
    special_discount DECIMAL(5, 2),
    last_order_date DATE,
    credit_status VARCHAR(20) DEFAULT 'none' CHECK (credit_status IN ('paid', 'pending', 'none')),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ==========================================
-- 4. TABLAS DE ROLES Y PERMISOS
-- ==========================================

-- Tabla: roles
CREATE TABLE roles (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    level INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_by VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Tabla: permissions
CREATE TABLE permissions (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    module VARCHAR(255) NOT NULL,
    action VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Tabla: permission_role (tabla pivote)
CREATE TABLE permission_role (
    role_id BIGINT NOT NULL,
    permission_id BIGINT NOT NULL,
    assigned_date DATE NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    PRIMARY KEY (role_id, permission_id),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
);

-- Tabla: role_user (tabla pivote)
CREATE TABLE role_user (
    user_id BIGINT NOT NULL,
    role_id BIGINT NOT NULL,
    assigned_date DATE NOT NULL,
    expiration_date DATE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    PRIMARY KEY (user_id, role_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

-- ==========================================
-- 5. TABLA DE AUDITORÍA
-- ==========================================

-- Tabla: audit_logs
CREATE TABLE audit_logs (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    action VARCHAR(255) NOT NULL,
    affected_model VARCHAR(255),
    changes JSON,
    affected_model_id BIGINT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- ==========================================
-- 6. CATÁLOGOS DE PRODUCTOS
-- ==========================================

-- Tabla: colors
CREATE TABLE colors (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Tabla: categories (jerarquía auto-referencial)
CREATE TABLE categories (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category_id BIGINT,
    level INTEGER DEFAULT 1,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Tabla: brands
CREATE TABLE brands (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Tabla: measures
CREATE TABLE measures (
    id BIGSERIAL PRIMARY KEY,
    length DECIMAL(10, 2),
    length_unit VARCHAR(10) DEFAULT 'cm' CHECK (length_unit IN ('m', 'cm', 'mm', 'in')),
    width DECIMAL(10, 2),
    width_unit VARCHAR(10) DEFAULT 'cm' CHECK (width_unit IN ('m', 'cm', 'mm', 'in')),
    height DECIMAL(10, 2),
    height_unit VARCHAR(10) DEFAULT 'cm' CHECK (height_unit IN ('m', 'cm', 'mm', 'in')),
    thickness DECIMAL(10, 2),
    thickness_unit VARCHAR(10) DEFAULT 'mm' CHECK (thickness_unit IN ('mm', 'in', 'gauge')),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE (length, length_unit, width, width_unit, height, height_unit, thickness, thickness_unit)
);

-- Tabla: volumes
CREATE TABLE volumes (
    id BIGSERIAL PRIMARY KEY,
    peso DECIMAL(10, 2),
    peso_unit VARCHAR(10) DEFAULT 'kg' CHECK (peso_unit IN ('kg', 'g', 'lb', 'oz')),
    volume DECIMAL(10, 2),
    volume_unit VARCHAR(10) DEFAULT 'L' CHECK (volume_unit IN ('L', 'ml', 'gal', 'oz')),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE (peso, peso_unit, volume, volume_unit)
);

-- Tabla: products
CREATE TABLE products (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    image VARCHAR(255),
    purchase_price DECIMAL(10, 2) NOT NULL,
    purchase_price_unit VARCHAR(10) DEFAULT 'USD' CHECK (purchase_price_unit IN ('USD', 'EUR', 'BOB', 'ARS', 'CLP', 'COP', 'MXN', 'PEN')),
    sale_price DECIMAL(10, 2) NOT NULL,
    sale_price_unit VARCHAR(10) DEFAULT 'USD' CHECK (sale_price_unit IN ('USD', 'EUR', 'BOB', 'ARS', 'CLP', 'COP', 'MXN', 'PEN')),
    input INTEGER DEFAULT 0,
    output INTEGER DEFAULT 0,
    stock INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    category_id BIGINT NOT NULL,
    color_id BIGINT,
    brand_id BIGINT,
    measure_id BIGINT,
    volume_id BIGINT,
    expiration_date DATE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
    FOREIGN KEY (color_id) REFERENCES colors(id) ON DELETE SET NULL,
    FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE SET NULL,
    FOREIGN KEY (measure_id) REFERENCES measures(id) ON DELETE SET NULL,
    FOREIGN KEY (volume_id) REFERENCES volumes(id) ON DELETE SET NULL
);

-- Tabla: technical_specifications
CREATE TABLE technical_specifications (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Tabla: product_technical_specification (tabla pivote)
CREATE TABLE product_technical_specification (
    id BIGSERIAL PRIMARY KEY,
    product_id BIGINT NOT NULL,
    technical_specification_id BIGINT NOT NULL,
    value TEXT NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (technical_specification_id) REFERENCES technical_specifications(id) ON DELETE CASCADE
);

-- Tabla: product_alerts
CREATE TABLE product_alerts (
    id BIGSERIAL PRIMARY KEY,
    alert_type VARCHAR(50) NOT NULL CHECK (alert_type IN ('upcoming_expiration', 'expired', 'low_stock', 'promotion', 'out_of_stock')),
    threshold_value DECIMAL(10, 2),
    message TEXT,
    priority VARCHAR(20) DEFAULT 'medium' CHECK (priority IN ('low', 'medium', 'high')),
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'read', 'ignored')),
    visible_to JSON DEFAULT '["Administrador", "Vendedor", "Cliente", "Proveedor"]',
    user_id BIGINT,
    product_id BIGINT,
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE INDEX product_alerts_alert_type_index ON product_alerts(alert_type);
CREATE INDEX product_alerts_status_index ON product_alerts(status);
CREATE INDEX product_alerts_active_index ON product_alerts(active);
CREATE INDEX product_alerts_user_id_active_index ON product_alerts(user_id, active);

-- ==========================================
-- 7. MÉTODOS DE PAGO Y PAGOS
-- ==========================================

-- Tabla: payment_methods
CREATE TABLE payment_methods (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    provider VARCHAR(255),
    credentials JSON,
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    requires_gateway BOOLEAN DEFAULT FALSE,
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Tabla: payments
CREATE TABLE payments (
    id BIGSERIAL PRIMARY KEY,
    payment_method_id BIGINT NOT NULL,
    transaction_id VARCHAR(255) UNIQUE,
    reference_number VARCHAR(255),
    amount DECIMAL(10, 2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'USD',
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'processing', 'completed', 'failed', 'refunded', 'cancelled')),
    gateway_response JSON,
    notes TEXT,
    payment_proof VARCHAR(255),
    paid_at TIMESTAMP,
    refunded_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id) ON DELETE RESTRICT
);

CREATE INDEX payments_status_index ON payments(status);
CREATE INDEX payments_paid_at_index ON payments(paid_at);

-- ==========================================
-- 8. ENTRADAS DE INVENTARIO
-- ==========================================

-- Tabla: entries
CREATE TABLE entries (
    id BIGSERIAL PRIMARY KEY,
    invoice_number VARCHAR(255) UNIQUE NOT NULL,
    invoice_date DATE NOT NULL,
    document_type VARCHAR(30) DEFAULT 'FACTURA' CHECK (document_type IN ('FACTURA', 'NOTA_FISCAL', 'RECIBO', 'GUIA_REMISION', 'NOTA_CREDITO', 'NOTA_DEBITO', 'ORDEN_COMPRA', 'AJUSTE_INVENTARIO')),
    total DECIMAL(10, 2) NOT NULL,
    supplier_id BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Tabla: entry_payments
CREATE TABLE entry_payments (
    id BIGSERIAL PRIMARY KEY,
    entry_id BIGINT NOT NULL,
    payment_method_id BIGINT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (entry_id) REFERENCES entries(id) ON DELETE CASCADE,
    FOREIGN KEY (payment_method_id) REFERENCES payment_methods(id) ON DELETE RESTRICT
);

-- Tabla: entry_details
CREATE TABLE entry_details (
    id BIGSERIAL PRIMARY KEY,
    entry_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (entry_id) REFERENCES entries(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);

CREATE INDEX entry_details_entry_id_index ON entry_details(entry_id);
CREATE INDEX entry_details_product_id_index ON entry_details(product_id);

-- ==========================================
-- 9. VENTAS
-- ==========================================

-- Tabla: sales
CREATE TABLE sales (
    id BIGSERIAL PRIMARY KEY,
    invoice_number VARCHAR(255) UNIQUE NOT NULL,
    customer_id BIGINT,
    delivered_by BIGINT,
    shipping_address TEXT,
    shipping_city VARCHAR(255),
    shipping_state VARCHAR(255),
    shipping_zip VARCHAR(255),
    shipping_country VARCHAR(2) DEFAULT 'BO',
    shipping_notes TEXT,
    payment_id BIGINT,
    subtotal DECIMAL(10, 2) NOT NULL,
    discount DECIMAL(10, 2) DEFAULT 0,
    discount_code VARCHAR(255),
    tax DECIMAL(10, 2) DEFAULT 0,
    shipping_cost DECIMAL(10, 2) DEFAULT 0,
    total DECIMAL(10, 2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'USD',
    status VARCHAR(20) DEFAULT 'pending' CHECK (status IN ('pending', 'processing', 'paid', 'preparing', 'shipped', 'delivered', 'cancelled', 'refunded')),
    notes TEXT,
    admin_notes TEXT,
    sale_type VARCHAR(20) DEFAULT 'online' CHECK (sale_type IN ('online', 'pos', 'phone', 'whatsapp')),
    shipping_method VARCHAR(255),
    tracking_number VARCHAR(255),
    carrier VARCHAR(255),
    paid_at TIMESTAMP,
    preparing_at TIMESTAMP,
    shipped_at TIMESTAMP,
    delivered_at TIMESTAMP,
    cancelled_at TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (delivered_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (payment_id) REFERENCES payments(id) ON DELETE SET NULL
);

-- Tabla: sale_unpersons
CREATE TABLE sale_unpersons (
    id BIGSERIAL PRIMARY KEY,
    sale_id BIGINT,
    invoice_number VARCHAR(255) UNIQUE NOT NULL,
    customer_id BIGINT NOT NULL,
    payment_id BIGINT,
    subtotal DECIMAL(10, 2) NOT NULL,
    discount DECIMAL(10, 2) DEFAULT 0,
    tax DECIMAL(10, 2) DEFAULT 0,
    total DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) DEFAULT 'draft' CHECK (status IN ('draft', 'pending_payment', 'paid', 'cancelled')),
    notes TEXT,
    transaction_reference VARCHAR(255),
    payment_date TIMESTAMP,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (payment_id) REFERENCES payments(id) ON DELETE RESTRICT
);

-- Tabla: sale_details
CREATE TABLE sale_details (
    id BIGSERIAL PRIMARY KEY,
    sale_id BIGINT,
    sale_unperson_id BIGINT,
    product_id BIGINT NOT NULL,
    quantity INTEGER NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    discount_percentage DECIMAL(5, 2) DEFAULT 0,
    subtotal DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);

-- ==========================================
-- 10. DESCUENTOS
-- ==========================================

-- Tabla: discounts
CREATE TABLE discounts (
    id BIGSERIAL PRIMARY KEY,
    description VARCHAR(150) NOT NULL,
    discount_type VARCHAR(20) NOT NULL CHECK (discount_type IN ('PERCENTAGE', 'FIXED')),
    discount_value DECIMAL(10, 2) DEFAULT 0,
    code VARCHAR(50) UNIQUE NOT NULL,
    max_uses INTEGER DEFAULT 1,
    used_count INTEGER DEFAULT 0,
    min_amount DECIMAL(10, 2),
    is_active BOOLEAN DEFAULT TRUE,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- ==========================================
-- 11. NOTAS DE SALIDA
-- ==========================================

-- Tabla: exit_notes
CREATE TABLE exit_notes (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT,
    exit_type VARCHAR(20) NOT NULL CHECK (exit_type IN ('expired', 'damaged', 'company_use')),
    source VARCHAR(20) DEFAULT 'manual' CHECK (source IN ('manual', 'automatic')),
    reason TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Tabla: exit_note_items
CREATE TABLE exit_note_items (
    id BIGSERIAL PRIMARY KEY,
    exit_note_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    quantity INTEGER NOT NULL,
    reason VARCHAR(255) NOT NULL,
    unit_price DECIMAL(10, 2) DEFAULT 0,
    subtotal DECIMAL(10, 2) DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (exit_note_id) REFERENCES exit_notes(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- ==========================================
-- 12. RESEÑAS DE PRODUCTOS
-- ==========================================

-- Tabla: reviews
CREATE TABLE reviews (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    product_id BIGINT NOT NULL,
    rating SMALLINT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'approved' CHECK (status IN ('pending', 'approved', 'rejected')),
    helpful_count INTEGER DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE (user_id, product_id)
);

CREATE INDEX reviews_product_id_index ON reviews(product_id);
CREATE INDEX reviews_status_index ON reviews(status);
CREATE INDEX reviews_product_id_status_index ON reviews(product_id, status);

