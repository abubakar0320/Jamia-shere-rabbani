<?php
require_once 'includes/header.php';

// Define gallery categories and images
$categories = [
    'campus' => 'Campus Views',
    'events' => 'Events & Programs',
    'Fees' => 'Fees and calculations',
    'facilities' => 'Facilities',
    'achievements' => 'Achievements'
];

$gallery_images = [
    [
        'id' => 1,
        'category' => 'campus',
       'url' => 'images/image_(1).jpg',
'thumbnail' => 'images/image_(1).jpg',

        'caption' => 'Main Campus Building',
        'description' => 'The iconic main building of Jamia Shere Rabbani Mananwala'
    ],
    [
        'id' => 2,
        'category' => 'campus',
        'url' => 'images/image_(5).jpg',
        'thumbnail' => 'images/image_(5).jpg',
        'caption' => 'Library Complex',
        'description' => 'Our state-of-the-art library facility'
    ],
    [
        'id' => 2,
        'category' => 'campus',
        'url' => 'images/image_(6).jpg',
        'thumbnail' => 'images/image_(6).jpg',
        'caption' => 'Library Complex',
        'description' => 'Our state-of-the-art library facility'
    ],
    [
        'id' => 2,
        'category' => 'campus',
        'url' => 'images/image_(7).jpg',
        'thumbnail' => 'images/image_(7).jpg',
        'caption' => 'Library Complex',
        'description' => 'Our state-of-the-art library facility'
    ],
    [
        'id' => 2,
        'category' => 'campus',
        'url' => 'images/image_(8).jpg',
        'thumbnail' => 'images/image_(8).jpg',
        'caption' => 'Library Complex',
        'description' => 'Our state-of-the-art library facility'
    ],
    [
        'id' => 2,
        'category' => 'campus',
        'url' => 'images/image_(9).jpg',
        'thumbnail' => 'images/image_(9).jpg',
        'caption' => 'Library Complex',
        'description' => 'Our state-of-the-art library facility'
    ],
    [
        'id' => 2,
        'category' => 'campus',
        'url' => 'images/image_(10).jpg',
        'thumbnail' => 'images/image_(10).jpg',
        'caption' => 'Library Complex',
        'description' => 'Our state-of-the-art library facility'
    ],
    [
        'id' => 2,
        'category' => 'campus',
        'url' => 'images/image_(11).jpg',
        'thumbnail' => 'images/image_(11).jpg',
        'caption' => 'Library Complex',
        'description' => 'Our state-of-the-art library facility'
    ],
    [
        'id' => 2,
        'category' => 'campus',
        'url' => 'images/image_(12).jpg',
        'thumbnail' => 'images/image_(12).jpg',
        'caption' => 'Library Complex',
        'description' => 'Our state-of-the-art library facility'
    ],
    [
        'id' => 2,
        'category' => 'campus',
        'url' => 'images/image_(13).jpg',
        'thumbnail' => 'images/image_(13).jpg',
        'caption' => 'Library Complex',
        'description' => 'Our state-of-the-art library facility'
    ],
    [
        'id' => 2,
        'category' => 'campus',
        'url' => 'images/image_(14).jpg',
        'thumbnail' => 'images/image_(14).jpg',
        'caption' => 'Library Complex',
        'description' => 'Our state-of-the-art library facility'
    ],
    [
        'id' => 2,
        'category' => 'campus',
        'url' => 'images/image_(15).jpg',
        'thumbnail' => 'images/image_(15).jpg',
        'caption' => 'Library Complex',
        'description' => 'Our state-of-the-art library facility'
    ],
    [
        'id' => 3,
        'category' => 'events',
        'url' => 'images/image_(4).jpg',
        'thumbnail' => 'images/image_(4).jpg',
        'caption' => 'Annual Graduation Ceremony',
        'description' => 'Celebrating our graduates\' achievements'
    ],
    [
        'id' => 4,
        'category' => 'classes',
        'url' => 'images/image_(3).jpg',
        'thumbnail' => 'images/image_(3).jpg',
        'caption' => 'Islamic Studies Class',
        'description' => 'Students engaged in learning'
    ],
    [
        'id' => 5,
        'category' => 'Fees',
        'url' => 'images/image_(2).jpg',
        'thumbnail' => 'images/image_(2).jpg',
        'caption' => 'Modern Computer Lab',
        'description' => 'Technology integration in Islamic education'
    ],
    [
        'id' => 6,
        'category' => 'achievements',
        'url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1',
        'thumbnail' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=400',
        'caption' => 'Research Awards',
        'description' => 'Recognition of our scholarly achievements'
    ]
];
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">Photo Gallery</h1>
            <p class="mt-4 text-gray-600">Explore our institution through images</p>
        </div>

        <!-- Gallery Controls -->
        <div class="mb-8 flex flex-wrap gap-4 justify-center">
            <div class="flex flex-wrap justify-center gap-4">
                <button
                    class="filter-btn active px-6 py-2 bg-green-800 text-white rounded-full hover:bg-green-700 transition-all"
                    data-category="all"
                >
                    All
                </button>
                <?php foreach ($categories as $key => $name): ?>
                    <button
                        class="filter-btn px-6 py-2 bg-white text-gray-700 rounded-full hover:bg-green-50 transition-all"
                        data-category="<?php echo $key; ?>"
                    >
                        <?php echo $name; ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <div class="flex gap-4">
                <button
                    id="viewGrid"
                    class="view-btn active p-2 bg-green-800 text-white rounded-lg hover:bg-green-700 transition-all"
                    title="Grid View"
                >
                    <i data-lucide="grid" class="w-5 h-5"></i>
                </button>
                <button
                    id="viewMasonry"
                    class="view-btn p-2 bg-white text-gray-700 rounded-lg hover:bg-green-50 transition-all"
                    title="Masonry View"
                >
                    <i data-lucide="layout-grid" class="w-5 h-5"></i>
                </button>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div id="gallery" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($gallery_images as $image): ?>
                <div
                    class="gallery-item"
                    data-category="<?php echo $image['category']; ?>"
                    data-id="<?php echo $image['id']; ?>"
                >
                    <div class="relative group overflow-hidden rounded-lg shadow-md">
                        <img
                            src="<?php echo $image['thumbnail']; ?>"
                            alt="<?php echo $image['caption']; ?>"
                            class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-300"
                            loading="lazy"
                        >
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-60 transition-all duration-300">
                            <div class="absolute inset-0 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <h3 class="text-white text-lg font-bold mb-2 text-center px-4">
                                    <?php echo $image['caption']; ?>
                                </h3>
                                <div class="flex gap-2">
                                    <button
                                        onclick="openLightbox(<?php echo $image['id']; ?>)"
                                        class="p-2 bg-white bg-opacity-20 rounded-full hover:bg-opacity-30 transition-all"
                                        title="View Full Image"
                                    >
                                        <i data-lucide="zoom-in" class="w-6 h-6 text-white"></i>
                                    </button>
                                    <button
                                        onclick="shareImage(<?php echo $image['id']; ?>)"
                                        class="p-2 bg-white bg-opacity-20 rounded-full hover:bg-opacity-30 transition-all"
                                        title="Share Image"
                                    >
                                        <i data-lucide="share-2" class="w-6 h-6 text-white"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50">
    <div class="absolute top-4 right-4 flex gap-4">
        <button
            id="downloadBtn"
            class="p-2 text-white hover:text-gray-300 transition-colors"
            title="Download Image"
        >
            <i data-lucide="download" class="w-8 h-8"></i>
        </button>
        <button
            id="shareBtn"
            class="p-2 text-white hover:text-gray-300 transition-colors"
            title="Share Image"
        >
            <i data-lucide="share-2" class="w-8 h-8"></i>
        </button>
        <button
            onclick="closeLightbox()"
            class="p-2 text-white hover:text-gray-300 transition-colors"
            title="Close"
        >
            <i data-lucide="x" class="w-8 h-8"></i>
        </button>
    </div>
    
    <button
        id="prevImage"
        class="absolute left-4 top-1/2 -translate-y-1/2 p-2 text-white hover:text-gray-300 transition-colors"
    >
        <i data-lucide="chevron-left" class="w-8 h-8"></i>
    </button>
    
    <button
        id="nextImage"
        class="absolute right-4 top-1/2 -translate-y-1/2 p-2 text-white hover:text-gray-300 transition-colors"
    >
        <i data-lucide="chevron-right" class="w-8 h-8"></i>
    </button>

    <div class="flex items-center justify-center h-full">
        <div class="max-w-5xl w-full mx-4">
            <img
                id="lightbox-image"
                src=""
                alt=""
                class="w-full h-auto rounded-lg shadow-2xl"
            >
            <div class="text-center mt-4">
                <h3 id="lightbox-caption" class="text-white text-xl font-bold"></h3>
                <p id="lightbox-description" class="text-gray-300 mt-2"></p>
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div id="shareModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" style="display: none;">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold">Share Image</h3>
            <button onclick="closeShareModal()" class="text-gray-500 hover:text-gray-700">
                <i data-lucide="x" class="w-6 h-6"></i>
            </button>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <button
                onclick="shareVia('facebook')"
                class="flex items-center justify-center gap-2 p-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
                <i data-lucide="facebook" class="w-5 h-5"></i>
                Facebook
            </button>
            <button
                onclick="shareVia('twitter')"
                class="flex items-center justify-center gap-2 p-3 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-colors"
            >
                <i data-lucide="twitter" class="w-5 h-5"></i>
                Twitter
            </button>
            <button
                onclick="shareVia('whatsapp')"
                class="flex items-center justify-center gap-2 p-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors"
            >
                <i data-lucide="message-circle" class="w-5 h-5"></i>
                WhatsApp
            </button>
            <button
                onclick="shareVia('email')"
                class="flex items-center justify-center gap-2 p-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
            >
                <i data-lucide="mail" class="w-5 h-5"></i>
                Email
            </button>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Image Link</label>
            <div class="flex gap-2">
                <input
                    type="text"
                    id="shareLink"
                    class="flex-1 border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                    readonly
                >
                <button
                    onclick="copyShareLink()"
                    class="px-4 py-2 bg-green-800 text-white rounded-lg hover:bg-green-700 transition-colors"
                >
                    Copy
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Gallery filtering
const filterButtons = document.querySelectorAll('.filter-btn');
const galleryItems = document.querySelectorAll('.gallery-item');
const gallery = document.getElementById('gallery');
const viewButtons = document.querySelectorAll('.view-btn');

filterButtons.forEach(button => {
    button.addEventListener('click', () => {
        const category = button.dataset.category;
        
        // Update active button
        filterButtons.forEach(btn => btn.classList.remove('active', 'bg-green-800', 'text-white'));
        button.classList.add('active', 'bg-green-800', 'text-white');
        
        // Filter items
        galleryItems.forEach(item => {
            if (category === 'all' || item.dataset.category === category) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});

// View switching
viewButtons.forEach(button => {
    button.addEventListener('click', () => {
        viewButtons.forEach(btn => {
            btn.classList.remove('active', 'bg-green-800', 'text-white');
            btn.classList.add('bg-white', 'text-gray-700');
        });
        button.classList.remove('bg-white', 'text-gray-700');
        button.classList.add('active', 'bg-green-800', 'text-white');
        
        if (button.id === 'viewMasonry') {
            gallery.classList.remove('grid-cols-1', 'md:grid-cols-3', 'lg:grid-cols-4');
            gallery.classList.add('columns-1', 'md:columns-3', 'lg:columns-4', 'gap-6');
            galleryItems.forEach(item => {
                item.style.marginBottom = '1.5rem';
            });
        } else {
            gallery.classList.add('grid-cols-1', 'md:grid-cols-3', 'lg:grid-cols-4');
            gallery.classList.remove('columns-1', 'md:columns-3', 'lg:columns-4', 'gap-6');
            galleryItems.forEach(item => {
                item.style.marginBottom = '0';
            });
        }
    });
});

// Lightbox functionality
const images = <?php echo json_encode($gallery_images); ?>;
let currentImageIndex = 0;

function openLightbox(imageId) {
    const image = images.find(img => img.id === imageId);
    if (!image) return;
    
    currentImageIndex = images.findIndex(img => img.id === imageId);
    updateLightboxContent();
    
    document.getElementById('lightbox').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function updateLightboxContent() {
    const image = images[currentImageIndex];
    document.getElementById('lightbox-image').src = image.url;
    document.getElementById('lightbox-caption').textContent = image.caption;
    document.getElementById('lightbox-description').textContent = image.description;
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('prevImage').addEventListener('click', () => {
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    updateLightboxContent();
});

document.getElementById('nextImage').addEventListener('click', () => {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    updateLightboxContent();
});

// Share functionality
function shareImage(imageId) {
    const image = images.find(img => img.id === imageId);
    if (!image) return;
    
    document.getElementById('shareLink').value = image.url;
    document.getElementById('shareModal').classList.remove('hidden');
}

function closeShareModal() {
    document.getElementById('shareModal').classList.add('hidden');
}

function shareVia(platform) {
    const image = images[currentImageIndex];
    const url = encodeURIComponent(image.url);
    const text = encodeURIComponent(`Check out this image from Jamia Shere Rabbani Mananwala: ${image.caption}`);
    
    let shareUrl = '';
    switch (platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
        case 'twitter':
            shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
            break;
        case 'whatsapp':
            shareUrl = `https://api.whatsapp.com/send?text=${text}%20${url}`;
            break;
        case 'email':
            shareUrl = `mailto:?subject=${text}&body=${url}`;
            break;
    }
    
    if (shareUrl) {
        window.open(shareUrl, '_blank');
    }
}

function copyShareLink() {
    const linkInput = document.getElementById('shareLink');
    linkInput.select();
    document.execCommand('copy');
    
    const button = linkInput.nextElementSibling;
    const originalText = button.textContent;
    button.textContent = 'Copied!';
    setTimeout(() => {
        button.textContent = originalText;
    }, 2000);
}

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    if (document.getElementById('lightbox').classList.contains('hidden')) return;
    
    switch (e.key) {
        case 'ArrowLeft':
            document.getElementById('prevImage').click();
            break;
        case 'ArrowRight':
            document.getElementById('nextImage').click();
            break;
        case 'Escape':
            closeLightbox();
            break;
    }
});

// Download functionality
document.getElementById('downloadBtn').addEventListener('click', () => {
    const image = images[currentImageIndex];
    const link = document.createElement('a');
    link.href = image.url;
    link.download = `jsrm-${image.caption.toLowerCase().replace(/\s+/g, '-')}.jpg`;
    link.click();
});
</script>

<style>
.gallery-item img {
    transition: transform 0.3s ease-in-out;
}

.gallery-item:hover img {
    transform: scale(1.1);
}

.filter-btn.active,
.view-btn.active {
    background-color: #2d3748; /* bg-green-800 */
    color: #ffffff; /* text-white */
}

/* Masonry layout styles */
@media (min-width: 768px) {
    .columns-1 {
        column-count: 1;
    }
    .md\:columns-3 {
        column-count: 3;
    }
    .lg\:columns-4 {
        column-count: 4;
    }
}

/* Animation classes */
.gallery-item {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>