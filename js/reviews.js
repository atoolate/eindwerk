document.addEventListener('DOMContentLoaded', function() {
    const reviewForm = document.getElementById('review-form');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);

            fetch('submit_review.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const reviewsDiv = document.getElementById('reviews');
                    const newReview = document.createElement('div');
                    newReview.classList.add('review');
                    newReview.innerHTML = `
                        <p><strong>${data.review.author}</strong></p>
                        <p>${data.review.content}</p>
                    `;
                    reviewsDiv.appendChild(newReview);
                    this.reset();
                } else {
                    alert('Failed to submit review. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while submitting your review. Please check your internet connection and try again.');
            });
        });
    }
});