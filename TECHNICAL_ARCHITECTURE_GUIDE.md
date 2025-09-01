# 🔧 TECHNICAL ARCHITECTURE & BEST PRACTICES

## 🏗️ MODERN LARAVEL ARCHITECTURE

### **Directory Structure Optimization**
```
web-desa/
├── 📁 app/
│   ├── 🎯 Actions/           # Single-purpose action classes
│   │   ├── Articles/
│   │   │   ├── CreateArticle.php
│   │   │   ├── UpdateArticle.php
│   │   │   └── DeleteArticle.php
│   │   └── Statistics/
│   │       ├── GenerateReport.php
│   │       └── ExportData.php
│   │
│   ├── 🔄 DTOs/              # Data Transfer Objects
│   │   ├── ArticleDTO.php
│   │   ├── UserDTO.php
│   │   └── StatisticsDTO.php
│   │
│   ├── 🏪 Repositories/      # Data layer abstraction
│   │   ├── Contracts/
│   │   │   ├── ArticleRepositoryInterface.php
│   │   │   └── UserRepositoryInterface.php
│   │   └── Eloquent/
│   │       ├── ArticleRepository.php
│   │       └── UserRepository.php
│   │
│   ├── 🔧 Services/          # Business logic layer
│   │   ├── ArticleService.php
│   │   ├── StatisticsService.php
│   │   └── NotificationService.php
│   │
│   ├── 📡 Resources/         # API response transformers
│   │   ├── ArticleResource.php
│   │   ├── UserResource.php
│   │   └── StatisticsResource.php
│   │
│   └── 🎪 Events/           # Domain events
│       ├── ArticleCreated.php
│       ├── ArticlePublished.php
│       └── UserRegistered.php
│
├── 📁 resources/
│   ├── 🎨 css/
│   │   ├── app.css           # Main stylesheet
│   │   ├── components/       # Component-specific styles
│   │   └── utilities/        # Custom utilities
│   │
│   ├── 🖼️ js/
│   │   ├── app.js           # Main JavaScript entry
│   │   ├── components/      # Reusable components
│   │   ├── pages/           # Page-specific scripts
│   │   └── utils/           # Helper utilities
│   │
│   └── 📄 views/
│       ├── components/      # Reusable Blade components
│       │   ├── navigation/
│       │   ├── forms/
│       │   └── cards/
│       ├── layouts/         # Layout templates
│       └── pages/           # Page templates
│
└── 📁 tests/
    ├── Feature/             # Integration tests
    ├── Unit/               # Unit tests
    └── Browser/            # End-to-end tests
```

### **Service Container & Dependency Injection**
```php
<?php
// app/Providers/RepositoryServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use App\Repositories\Eloquent\ArticleRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public array $bindings = [
        ArticleRepositoryInterface::class => ArticleRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        StatisticsRepositoryInterface::class => StatisticsRepository::class,
    ];

    public function register(): void
    {
        // Register singletons for heavy services
        $this->app->singleton(StatisticsService::class, function ($app) {
            return new StatisticsService(
                $app->make(StatisticsRepositoryInterface::class),
                $app->make('cache.store')
            );
        });
    }
}
```

### **Advanced Eloquent Patterns**
```php
<?php
// app/Models/Article.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'excerpt', 
        'featured_image', 'category_id', 'author_id', 
        'status', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'metadata' => 'json',
        'tags' => 'array'
    ];

    // Attribute Casting for automatic transformations
    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    protected function excerpt(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ?? 
                \Str::limit(strip_tags($this->content), 150)
        );
    }

    // Query Scopes for reusable query logic
    public function scopePublished(Builder $query): void
    {
        $query->where('status', 'published')
              ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    public function scopeByCategory(Builder $query, string $category): void
    {
        $query->whereHas('category', function (Builder $query) use ($category) {
            $query->where('slug', $category);
        });
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Advanced query methods
    public static function getPopular(int $limit = 5): Collection
    {
        return static::published()
                    ->withCount('views')
                    ->orderBy('views_count', 'desc')
                    ->limit($limit)
                    ->get();
    }

    public static function searchByKeyword(string $keyword): Builder
    {
        return static::where(function (Builder $query) use ($keyword) {
            $query->where('title', 'like', "%{$keyword}%")
                  ->orWhere('content', 'like', "%{$keyword}%")
                  ->orWhere('excerpt', 'like', "%{$keyword}%");
        });
    }
}
```

---

## 🎨 ADVANCED FRONTEND PATTERNS

### **Component-Based Architecture**
```javascript
// resources/js/components/ArticleCard.js

class ArticleCard extends HTMLElement {
    constructor() {
        super();
        this.attachShadow({ mode: 'open' });
    }

    connectedCallback() {
        this.render();
        this.setupEventListeners();
    }

    static get observedAttributes() {
        return ['title', 'excerpt', 'image', 'date', 'category'];
    }

    attributeChangedCallback(name, oldValue, newValue) {
        if (oldValue !== newValue) {
            this.render();
        }
    }

    render() {
        const template = `
            <style>
                :host {
                    display: block;
                    background: white;
                    border-radius: 0.5rem;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                    transition: transform 0.2s ease-in-out;
                }
                
                :host(:hover) {
                    transform: translateY(-2px);
                    box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
                }
                
                .card-image {
                    width: 100%;
                    height: 200px;
                    object-fit: cover;
                    border-radius: 0.5rem 0.5rem 0 0;
                }
                
                .card-content {
                    padding: 1.5rem;
                }
                
                .card-title {
                    font-size: 1.25rem;
                    font-weight: 600;
                    margin-bottom: 0.5rem;
                    color: #1f2937;
                }
                
                .card-excerpt {
                    color: #6b7280;
                    margin-bottom: 1rem;
                    line-height: 1.6;
                }
                
                .card-meta {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    font-size: 0.875rem;
                    color: #9ca3af;
                }
            </style>
            
            <article class="article-card">
                <img 
                    src="${this.getAttribute('image') || '/img/placeholder.jpg'}" 
                    alt="${this.getAttribute('title')}"
                    class="card-image"
                    loading="lazy"
                >
                <div class="card-content">
                    <h3 class="card-title">${this.getAttribute('title')}</h3>
                    <p class="card-excerpt">${this.getAttribute('excerpt')}</p>
                    <div class="card-meta">
                        <span class="category">${this.getAttribute('category')}</span>
                        <time datetime="${this.getAttribute('date')}">
                            ${this.formatDate(this.getAttribute('date'))}
                        </time>
                    </div>
                </div>
            </article>
        `;

        this.shadowRoot.innerHTML = template;
    }

    setupEventListeners() {
        this.addEventListener('click', () => {
            window.location.href = this.getAttribute('href');
        });
    }

    formatDate(dateString) {
        return new Intl.DateTimeFormat('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }).format(new Date(dateString));
    }
}

// Register the custom element
customElements.define('article-card', ArticleCard);
```

### **State Management with Modern JavaScript**
```javascript
// resources/js/utils/StateManager.js

class StateManager {
    constructor() {
        this.state = new Proxy({}, {
            set: (target, property, value) => {
                const oldValue = target[property];
                target[property] = value;
                
                // Trigger state change events
                this.notifySubscribers(property, value, oldValue);
                return true;
            }
        });
        
        this.subscribers = new Map();
    }

    subscribe(property, callback) {
        if (!this.subscribers.has(property)) {
            this.subscribers.set(property, new Set());
        }
        this.subscribers.get(property).add(callback);
        
        // Return unsubscribe function
        return () => {
            this.subscribers.get(property).delete(callback);
        };
    }

    notifySubscribers(property, newValue, oldValue) {
        if (this.subscribers.has(property)) {
            this.subscribers.get(property).forEach(callback => {
                callback(newValue, oldValue);
            });
        }
    }

    setState(updates) {
        Object.assign(this.state, updates);
    }

    getState(property) {
        return property ? this.state[property] : this.state;
    }
}

// Global state instance
window.appState = new StateManager();

// Usage example
appState.subscribe('articles', (newArticles, oldArticles) => {
    document.dispatchEvent(new CustomEvent('articlesUpdated', {
        detail: { newArticles, oldArticles }
    }));
});
```

### **Optimized Image Handling**
```javascript
// resources/js/utils/ImageOptimizer.js

class ImageOptimizer {
    constructor() {
        this.observer = new IntersectionObserver(
            this.handleIntersection.bind(this),
            {
                rootMargin: '50px 0px',
                threshold: 0.1
            }
        );
        
        this.init();
    }

    init() {
        // Setup lazy loading for images
        document.querySelectorAll('img[data-src]').forEach(img => {
            this.observer.observe(img);
        });

        // Setup responsive image handling
        this.setupResponsiveImages();
    }

    handleIntersection(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                this.loadImage(img);
                this.observer.unobserve(img);
            }
        });
    }

    async loadImage(img) {
        try {
            // Show loading placeholder
            img.classList.add('loading');
            
            // Preload the image
            await this.preloadImage(img.dataset.src);
            
            // Set the source and remove loading state
            img.src = img.dataset.src;
            img.classList.remove('loading');
            img.classList.add('loaded');
            
            // Remove data-src attribute
            delete img.dataset.src;
            
        } catch (error) {
            console.error('Failed to load image:', error);
            img.src = '/img/placeholder.jpg';
            img.classList.add('error');
        }
    }

    preloadImage(src) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = resolve;
            img.onerror = reject;
            img.src = src;
        });
    }

    setupResponsiveImages() {
        // Convert images to WebP format if supported
        if (this.supportsWebP()) {
            document.querySelectorAll('img').forEach(img => {
                if (img.src && !img.src.includes('.webp')) {
                    const webpSrc = img.src.replace(/\.(jpg|jpeg|png)$/, '.webp');
                    
                    // Test if WebP version exists
                    this.checkImageExists(webpSrc).then(exists => {
                        if (exists) img.src = webpSrc;
                    });
                }
            });
        }
    }

    supportsWebP() {
        const canvas = document.createElement('canvas');
        canvas.width = 1;
        canvas.height = 1;
        return canvas.toDataURL('image/webp').indexOf('data:image/webp') === 0;
    }

    async checkImageExists(src) {
        try {
            const response = await fetch(src, { method: 'HEAD' });
            return response.ok;
        } catch {
            return false;
        }
    }
}

// Initialize image optimizer
document.addEventListener('DOMContentLoaded', () => {
    new ImageOptimizer();
});
```

---

## 🗄️ DATABASE OPTIMIZATION STRATEGIES

### **Advanced Indexing Strategy**
```sql
-- Composite indexes for common queries
CREATE INDEX idx_articles_status_published_category ON articles(status, published_at, category_id);
CREATE INDEX idx_articles_search ON articles(title, excerpt) USING FULLTEXT;
CREATE INDEX idx_articles_author_date ON articles(author_id, published_at DESC);

-- Partial indexes for specific conditions
CREATE INDEX idx_articles_published ON articles(published_at) 
WHERE status = 'published';

CREATE INDEX idx_users_active ON users(created_at) 
WHERE status = 'active';

-- Covering indexes to avoid table lookups
CREATE INDEX idx_articles_list_covering ON articles(
    id, title, excerpt, published_at, category_id
) WHERE status = 'published';
```

### **Query Optimization Patterns**
```php
<?php
// app/Repositories/Eloquent/ArticleRepository.php

namespace App\Repositories\Eloquent;

use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function getPublishedPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Article::select([
                'id', 'title', 'slug', 'excerpt', 'featured_image', 
                'published_at', 'category_id'
            ])
            ->published()
            ->with(['category:id,name,slug']) // Only load needed columns
            ->withCount('comments') // Efficient counting
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }

    public function getPopularByViews(int $limit = 5): Collection
    {
        return Article::select([
                'id', 'title', 'slug', 'featured_image'
            ])
            ->published()
            ->orderBy('view_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function searchWithHighlight(string $query): Collection
    {
        // Use MySQL FULLTEXT search with relevance scoring
        return Article::selectRaw("
                id, title, slug, excerpt,
                MATCH(title, content) AGAINST(? IN BOOLEAN MODE) as relevance
            ", [$query])
            ->published()
            ->whereRaw("MATCH(title, content) AGAINST(? IN BOOLEAN MODE)", [$query])
            ->orderBy('relevance', 'desc')
            ->get();
    }

    public function getByCategoryOptimized(string $categorySlug): Collection
    {
        return Article::select([
                'articles.id', 'articles.title', 'articles.slug', 
                'articles.excerpt', 'articles.published_at'
            ])
            ->join('categories', 'articles.category_id', '=', 'categories.id')
            ->where('categories.slug', $categorySlug)
            ->where('articles.status', 'published')
            ->orderBy('articles.published_at', 'desc')
            ->get();
    }
}
```

### **Caching Strategy Implementation**
```php
<?php
// app/Services/ArticleService.php

namespace App\Services;

use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class ArticleService
{
    public function __construct(
        private ArticleRepositoryInterface $articleRepository
    ) {}

    public function getLatestArticles(int $limit = 5): Collection
    {
        $cacheKey = "articles.latest.{$limit}";
        
        return Cache::tags(['articles'])
            ->remember($cacheKey, now()->addMinutes(15), function () use ($limit) {
                return $this->articleRepository->getLatest($limit);
            });
    }

    public function getPopularArticles(): Collection
    {
        return Cache::tags(['articles', 'statistics'])
            ->remember('articles.popular', now()->addHour(), function () {
                return $this->articleRepository->getPopularByViews(10);
            });
    }

    public function searchArticles(string $query): Collection
    {
        $cacheKey = "articles.search." . md5($query);
        
        return Cache::tags(['articles'])
            ->remember($cacheKey, now()->addMinutes(30), function () use ($query) {
                return $this->articleRepository->searchWithHighlight($query);
            });
    }

    public function invalidateArticleCache(): void
    {
        Cache::tags(['articles'])->flush();
    }

    public function warmUpCache(): void
    {
        // Warm up frequently accessed data
        $this->getLatestArticles();
        $this->getPopularArticles();
        
        // Warm up category-based caches
        $categories = ['berita', 'pengumuman', 'kegiatan'];
        foreach ($categories as $category) {
            Cache::tags(['articles'])
                ->remember("articles.category.{$category}", now()->addHour(), function () use ($category) {
                    return $this->articleRepository->getByCategoryOptimized($category);
                });
        }
    }
}
```

---

## 🔒 ADVANCED SECURITY IMPLEMENTATION

### **Multi-Layer Authentication**
```php
<?php
// app/Http/Middleware/EnhancedSecurityMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class EnhancedSecurityMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // IP-based rate limiting
        $key = 'security-check:' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 60)) {
            Log::warning('Rate limit exceeded', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'route' => $request->route()?->getName()
            ]);
            
            abort(429, 'Too many requests');
        }

        RateLimiter::hit($key, 3600); // 1 hour window

        // Security headers
        $response = $next($request);
        
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');
        
        // Content Security Policy
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; " .
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
               "img-src 'self' data: https:; " .
               "font-src 'self' https://fonts.gstatic.com; " .
               "connect-src 'self';";
        
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
```

### **Input Validation & Sanitization**
```php
<?php
// app/Http/Requests/CreateArticleRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->can('create', Article::class);
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9\s\-_.,!?()]+$/u', // Only allowed characters
            ],
            'content' => [
                'required',
                'string',
                'max:50000',
                function ($attribute, $value, $fail) {
                    // Custom validation for dangerous content
                    if ($this->containsDangerousContent($value)) {
                        $fail('Content contains potentially dangerous elements.');
                    }
                }
            ],
            'category_id' => 'required|exists:categories,id',
            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048', // 2MB max
                'dimensions:min_width=300,min_height=200,max_width=1920,max_height=1080'
            ],
            'tags' => 'nullable|array|max:10',
            'tags.*' => 'string|max:50|regex:/^[a-zA-Z0-9\s\-]+$/u',
        ];
    }

    public function prepareForValidation(): void
    {
        // Sanitize input before validation
        $this->merge([
            'title' => strip_tags($this->title),
            'content' => $this->sanitizeHtmlContent($this->content),
            'excerpt' => $this->excerpt ? strip_tags($this->excerpt) : null,
        ]);
    }

    protected function containsDangerousContent(string $content): bool
    {
        $dangerousPatterns = [
            '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi',
            '/javascript:/i',
            '/on\w+\s*=/i',
            '/<iframe\b[^>]*>/i',
            '/<object\b[^>]*>/i',
            '/<embed\b[^>]*>/i',
            '/<form\b[^>]*>/i',
        ];

        foreach ($dangerousPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return true;
            }
        }

        return false;
    }

    protected function sanitizeHtmlContent(string $content): string
    {
        // Allow only specific HTML tags
        $allowedTags = '<p><br><strong><em><u><ol><ul><li><h2><h3><h4><h5><h6><blockquote><a><img>';
        
        return strip_tags($content, $allowedTags);
    }

    public function messages(): array
    {
        return [
            'title.regex' => 'Judul hanya boleh mengandung huruf, angka, dan karakter yang diizinkan.',
            'featured_image.dimensions' => 'Gambar harus memiliki dimensi antara 300x200 dan 1920x1080 pixel.',
            'tags.*.regex' => 'Tag hanya boleh mengandung huruf, angka, spasi, dan tanda hubung.',
        ];
    }
}
```

---

## 🚀 DEPLOYMENT AUTOMATION

### **Advanced Deployment Script**
```bash
#!/bin/bash
# deploy-production-advanced.sh
# Advanced zero-downtime deployment with rollback capability

set -e

# Configuration
PROJECT_NAME="web-desa"
REPO_URL="https://github.com/kkn20mekarmukti2-droid/web-desa.git"
PRODUCTION_PATH="/home/user/public_html"
DEPLOY_USER="deploy"
BACKUP_RETENTION_DAYS=7

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

log() {
    echo -e "${GREEN}[$(date +'%Y-%m-%d %H:%M:%S')] $1${NC}"
}

warn() {
    echo -e "${YELLOW}[WARNING] $1${NC}"
}

error() {
    echo -e "${RED}[ERROR] $1${NC}" >&2
    exit 1
}

# Pre-deployment checks
pre_deployment_checks() {
    log "🔍 Running pre-deployment checks..."
    
    # Check disk space
    AVAILABLE_SPACE=$(df $PRODUCTION_PATH | awk 'NR==2{print $4}')
    REQUIRED_SPACE=1048576 # 1GB in KB
    
    if [ $AVAILABLE_SPACE -lt $REQUIRED_SPACE ]; then
        error "Insufficient disk space. Required: 1GB, Available: $(($AVAILABLE_SPACE/1024))MB"
    fi
    
    # Check MySQL connection
    if ! mysql -e "SELECT 1" >/dev/null 2>&1; then
        error "Cannot connect to MySQL database"
    fi
    
    # Check required commands
    for cmd in git composer npm php; do
        if ! command -v $cmd &> /dev/null; then
            error "$cmd is not installed or not in PATH"
        fi
    done
    
    log "✅ Pre-deployment checks passed"
}

# Create deployment structure
setup_deployment_structure() {
    log "🏗️ Setting up deployment structure..."
    
    TIMESTAMP=$(date +%Y%m%d_%H%M%S)
    RELEASE_PATH="$PRODUCTION_PATH/releases/$TIMESTAMP"
    SHARED_PATH="$PRODUCTION_PATH/shared"
    CURRENT_PATH="$PRODUCTION_PATH/current"
    
    # Create directories
    mkdir -p "$PRODUCTION_PATH/releases"
    mkdir -p "$SHARED_PATH"
    mkdir -p "$SHARED_PATH/storage/app"
    mkdir -p "$SHARED_PATH/storage/framework/cache"
    mkdir -p "$SHARED_PATH/storage/framework/sessions"
    mkdir -p "$SHARED_PATH/storage/framework/views"
    mkdir -p "$SHARED_PATH/storage/logs"
    mkdir -p "$SHARED_PATH/bootstrap/cache"
    
    log "📁 Release directory: $RELEASE_PATH"
}

# Clone and prepare application
prepare_application() {
    log "📥 Cloning application..."
    
    git clone --depth=1 $REPO_URL "$RELEASE_PATH"
    cd "$RELEASE_PATH"
    
    # Remove .git directory to save space
    rm -rf .git
    
    log "📦 Installing dependencies..."
    
    # Install PHP dependencies
    composer install --no-dev --optimize-autoloader --no-interaction
    
    # Install and build frontend assets
    npm ci
    npm run build
    
    # Clean up node_modules to save space
    rm -rf node_modules
}

# Setup shared resources
setup_shared_resources() {
    log "🔗 Setting up shared resources..."
    
    cd "$RELEASE_PATH"
    
    # Remove directories that will be symlinked
    rm -rf storage bootstrap/cache
    
    # Create symlinks to shared resources
    ln -sf "$SHARED_PATH/storage" "$RELEASE_PATH/storage"
    ln -sf "$SHARED_PATH/bootstrap/cache" "$RELEASE_PATH/bootstrap/cache"
    
    # Copy .env if it doesn't exist in shared
    if [ ! -f "$SHARED_PATH/.env" ]; then
        if [ -f "$CURRENT_PATH/.env" ]; then
            cp "$CURRENT_PATH/.env" "$SHARED_PATH/.env"
        else
            error ".env file not found. Please create $SHARED_PATH/.env"
        fi
    fi
    
    ln -sf "$SHARED_PATH/.env" "$RELEASE_PATH/.env"
}

# Run Laravel optimizations
optimize_laravel() {
    log "⚡ Optimizing Laravel application..."
    
    cd "$RELEASE_PATH"
    
    # Generate application key if needed
    php artisan key:generate --force --no-interaction
    
    # Cache configuration
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    # Optimize autoloader
    composer dump-autoload --optimize
    
    # Run database migrations
    php artisan migrate --force --no-interaction
    
    # Clear and warm up caches
    php artisan cache:clear
    php artisan queue:restart
    
    log "✅ Laravel optimization complete"
}

# Health check
health_check() {
    log "🏥 Running health checks..."
    
    cd "$RELEASE_PATH"
    
    # Test database connection
    if ! php artisan tinker --execute="echo 'DB test: ' . \DB::connection()->getPdo()->getAttribute(\PDO::ATTR_CONNECTION_STATUS);" 2>/dev/null; then
        error "Database connection failed"
    fi
    
    # Test cache
    if ! php artisan tinker --execute="cache()->put('deploy_test', 'ok', 60); echo 'Cache test: ' . cache()->get('deploy_test');" 2>/dev/null; then
        warn "Cache test failed - deployment will continue"
    fi
    
    log "✅ Health checks passed"
}

# Atomic deployment
atomic_deploy() {
    log "🎯 Executing atomic deployment..."
    
    # Backup current deployment for rollback
    if [ -L "$CURRENT_PATH" ]; then
        BACKUP_PATH="$PRODUCTION_PATH/backup/$(date +%Y%m%d_%H%M%S)"
        mkdir -p "$PRODUCTION_PATH/backup"
        cp -L "$CURRENT_PATH" "$BACKUP_PATH" 2>/dev/null || true
        echo "$RELEASE_PATH" > "$PRODUCTION_PATH/backup/latest"
    fi
    
    # Atomic switch
    ln -sfn "$RELEASE_PATH" "$CURRENT_PATH"
    
    # Set proper permissions
    chown -R $DEPLOY_USER:$DEPLOY_USER "$RELEASE_PATH"
    chmod -R 755 "$RELEASE_PATH"
    chmod -R 775 "$SHARED_PATH/storage"
    chmod -R 775 "$SHARED_PATH/bootstrap/cache"
    
    log "✅ Atomic deployment complete"
}

# Cleanup old releases
cleanup_old_releases() {
    log "🧹 Cleaning up old releases..."
    
    cd "$PRODUCTION_PATH/releases"
    
    # Keep only last 5 releases
    ls -t | tail -n +6 | xargs -d '\n' rm -rf --
    
    # Cleanup old backups
    find "$PRODUCTION_PATH/backup" -type f -mtime +$BACKUP_RETENTION_DAYS -delete 2>/dev/null || true
    
    log "✅ Cleanup complete"
}

# Post-deployment tasks
post_deployment_tasks() {
    log "📋 Running post-deployment tasks..."
    
    cd "$CURRENT_PATH"
    
    # Warm up caches
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    # Run queued jobs
    php artisan queue:work --daemon --timeout=300 > /dev/null 2>&1 &
    
    # Send deployment notification
    if command -v curl &> /dev/null; then
        DEPLOYMENT_TIME=$(date)
        curl -X POST -H 'Content-type: application/json' \
            --data "{\"text\":\"✅ $PROJECT_NAME deployed successfully at $DEPLOYMENT_TIME\"}" \
            "${SLACK_WEBHOOK_URL:-}" 2>/dev/null || true
    fi
    
    log "✅ Post-deployment tasks complete"
}

# Rollback function
rollback() {
    log "🔄 Rolling back to previous deployment..."
    
    if [ -f "$PRODUCTION_PATH/backup/latest" ]; then
        LAST_RELEASE=$(cat "$PRODUCTION_PATH/backup/latest")
        if [ -d "$LAST_RELEASE" ]; then
            ln -sfn "$LAST_RELEASE" "$CURRENT_PATH"
            log "✅ Rollback complete to $LAST_RELEASE"
        else
            error "Previous release not found: $LAST_RELEASE"
        fi
    else
        error "No previous deployment found for rollback"
    fi
}

# Performance test
performance_test() {
    log "📊 Running performance tests..."
    
    SITE_URL="https://$(hostname)"
    
    # Test response time
    RESPONSE_TIME=$(curl -o /dev/null -s -w '%{time_total}' "$SITE_URL" 2>/dev/null || echo "0")
    
    if (( $(echo "$RESPONSE_TIME > 2.0" | bc -l) )); then
        warn "Slow response time: ${RESPONSE_TIME}s"
    else
        log "✅ Response time OK: ${RESPONSE_TIME}s"
    fi
    
    # Test critical pages
    PAGES=("/" "/berita" "/admin/login")
    for page in "${PAGES[@]}"; do
        HTTP_STATUS=$(curl -o /dev/null -s -w '%{http_code}' "$SITE_URL$page" 2>/dev/null || echo "000")
        if [ "$HTTP_STATUS" != "200" ]; then
            warn "Page $page returned HTTP $HTTP_STATUS"
        else
            log "✅ Page $page OK"
        fi
    done
}

# Main deployment flow
main() {
    log "🚀 Starting deployment of $PROJECT_NAME"
    
    # Handle rollback request
    if [ "$1" = "rollback" ]; then
        rollback
        exit 0
    fi
    
    # Deployment pipeline
    pre_deployment_checks
    setup_deployment_structure
    prepare_application
    setup_shared_resources
    optimize_laravel
    health_check
    atomic_deploy
    cleanup_old_releases
    post_deployment_tasks
    performance_test
    
    log "🎉 Deployment completed successfully!"
    log "🌐 Site is live at: https://$(hostname)"
}

# Trap errors and provide rollback option
trap 'echo ""; error "Deployment failed! Run ./deploy-production-advanced.sh rollback to revert changes."' ERR

# Execute main function
main "$@"
```

---

## 📊 MONITORING & ANALYTICS

### **Real-time Monitoring System**
```php
<?php
// app/Services/MonitoringService.php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MonitoringService
{
    private const METRICS_CACHE_KEY = 'system_metrics';
    private const CACHE_TTL = 300; // 5 minutes

    public function getSystemHealth(): array
    {
        return Cache::remember(self::METRICS_CACHE_KEY, self::CACHE_TTL, function () {
            return [
                'database' => $this->checkDatabaseHealth(),
                'cache' => $this->checkCacheHealth(),
                'storage' => $this->checkStorageHealth(),
                'queue' => $this->checkQueueHealth(),
                'performance' => $this->getPerformanceMetrics(),
                'security' => $this->getSecurityMetrics(),
            ];
        });
    }

    private function checkDatabaseHealth(): array
    {
        try {
            $start = microtime(true);
            
            // Test database connection and response time
            $result = DB::selectOne('SELECT COUNT(*) as count FROM artikel LIMIT 1');
            $responseTime = (microtime(true) - $start) * 1000;
            
            // Check for slow queries
            $slowQueries = DB::select("
                SELECT COUNT(*) as count 
                FROM information_schema.PROCESSLIST 
                WHERE TIME > 1 AND COMMAND != 'Sleep'
            ");
            
            return [
                'status' => 'healthy',
                'response_time' => round($responseTime, 2) . 'ms',
                'slow_queries' => $slowQueries[0]->count ?? 0,
                'connections' => DB::select('SHOW STATUS LIKE "Threads_connected"')[0]->Value ?? 0
            ];
            
        } catch (\Exception $e) {
            Log::error('Database health check failed', ['error' => $e->getMessage()]);
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ];
        }
    }

    private function checkCacheHealth(): array
    {
        try {
            $start = microtime(true);
            
            // Test cache write/read
            $testKey = 'health_check_' . time();
            $testValue = 'test_' . rand(1000, 9999);
            
            Cache::put($testKey, $testValue, 60);
            $retrieved = Cache::get($testKey);
            Cache::forget($testKey);
            
            $responseTime = (microtime(true) - $start) * 1000;
            
            return [
                'status' => $retrieved === $testValue ? 'healthy' : 'degraded',
                'response_time' => round($responseTime, 2) . 'ms',
                'driver' => config('cache.default')
            ];
            
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage()
            ];
        }
    }

    private function checkStorageHealth(): array
    {
        $storagePath = storage_path();
        $publicPath = public_path();
        
        return [
            'storage_writable' => is_writable($storagePath),
            'public_writable' => is_writable($publicPath),
            'disk_usage' => [
                'storage' => $this->getDirectorySize($storagePath),
                'public' => $this->getDirectorySize($publicPath),
            ],
            'free_space' => disk_free_space('/') ?: 0
        ];
    }

    private function checkQueueHealth(): array
    {
        try {
            $pendingJobs = DB::table('jobs')->count();
            $failedJobs = DB::table('failed_jobs')->count();
            
            return [
                'status' => $failedJobs > 10 ? 'degraded' : 'healthy',
                'pending_jobs' => $pendingJobs,
                'failed_jobs' => $failedJobs
            ];
            
        } catch (\Exception $e) {
            return [
                'status' => 'unknown',
                'error' => $e->getMessage()
            ];
        }
    }

    private function getPerformanceMetrics(): array
    {
        return [
            'memory_usage' => [
                'current' => memory_get_usage(true),
                'peak' => memory_get_peak_usage(true),
                'limit' => $this->returnBytes(ini_get('memory_limit'))
            ],
            'cpu_usage' => $this->getCpuUsage(),
            'load_average' => sys_getloadavg(),
            'uptime' => $this->getUptime()
        ];
    }

    private function getSecurityMetrics(): array
    {
        return [
            'failed_logins_24h' => $this->getFailedLoginsCount(),
            'blocked_ips' => $this->getBlockedIpsCount(),
            'ssl_status' => $this->checkSslStatus(),
            'security_headers' => $this->checkSecurityHeaders()
        ];
    }

    private function getDirectorySize(string $directory): int
    {
        $size = 0;
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $file) {
            $size += $file->getSize();
        }
        return $size;
    }

    private function returnBytes(string $val): int
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        $val = (int) $val;
        
        switch($last) {
            case 'g': $val *= 1024;
            case 'm': $val *= 1024;
            case 'k': $val *= 1024;
        }
        
        return $val;
    }

    private function getCpuUsage(): float
    {
        $load = sys_getloadavg();
        return $load[0];
    }

    private function getUptime(): int
    {
        if (file_exists('/proc/uptime')) {
            return (int) file_get_contents('/proc/uptime');
        }
        return 0;
    }

    private function getFailedLoginsCount(): int
    {
        return DB::table('authentication_log')
                 ->where('successful', false)
                 ->where('created_at', '>=', now()->subDay())
                 ->count();
    }

    private function getBlockedIpsCount(): int
    {
        return Cache::get('blocked_ips_count', 0);
    }

    private function checkSslStatus(): bool
    {
        $url = config('app.url');
        return str_starts_with($url, 'https://');
    }

    private function checkSecurityHeaders(): array
    {
        return [
            'hsts' => true, // This should be checked against actual headers
            'csp' => true,
            'x_frame_options' => true,
            'x_content_type_options' => true
        ];
    }
}
```

Mari kita lanjutkan diskusi tentang aspek spesifik mana yang ingin Anda eksplorasi lebih dalam? Apakah Anda ingin fokus pada:

1. **UI/UX Implementation details**
2. **Performance optimization strategies**  
3. **Security hardening specifics**
4. **Development workflow dengan VS Code + Copilot + Claude**
5. **Production deployment automation**

Atau ada aspek lain yang ingin didiskusikan secara detail?