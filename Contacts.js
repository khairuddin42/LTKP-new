function toggleFAQ(faqId) {
    var faqContent = document.getElementById(faqId);
    if (faqContent.style.display === 'block') {
        faqContent.style.display = 'none';
    } else {
        // Hide all open FAQ contents first
        document.querySelectorAll('.faq-content').forEach(function(el) {
            el.style.display = 'none';
        });
        // Then show the clicked FAQ content
        faqContent.style.display = 'block';
    }
}
