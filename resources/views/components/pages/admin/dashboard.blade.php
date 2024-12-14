<!DOCTYPE html>
<html lang="en">

@include('includes.header')

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    header {
        background-color: #333;
        color: white;
        padding: 20px;
        text-align: center;
        position: relative;
    }

    header h1 {
        margin: 0;
        font-size: 24px;
    }

    header button {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    main {
        padding: 20px;
    }

    /* Grid Layout */
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .blog-card {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        position: relative;
    }

    .blog-card h3 {
        margin-top: 0;
    }

    .blog-card p {
        color: #666;
    }

    .blog-card button {
        padding: 5px 10px;
        margin-right: 5px;
        border: none;
        cursor: pointer;
        color: white;
    }

    .updateBtn {
        background-color: #007BFF;
    }

    .deleteBtn {
        background-color: #DC3545;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .modal-content h2 {
        margin-top: 0;
    }

    .modal-content form input,
    .modal-content form textarea {
        width: 100%;
        margin-bottom: 15px;
        padding: 10px;
        border: 1px solid #ddd;
    }

    .modal-content textarea {
        width: 100%;
        height: 150px;
        resize: vertical;
        box-sizing: border-box;
    }

    .modal-content button {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }

    .modal-content .cancelBtn {
        background-color: #f44336;
        margin-left: 10px;
    }



    .search-container {
        margin: 20px 0;
        text-align: center;
    }

    #searchInput {
        width: 50%;
        padding: 10px 20px;
        border: 2px solid #ddd;
        border-radius: 25px;
        font-size: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    #searchInput:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }


    /* Filter Section */
    .filter-section {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: auto;
        max-width: 800px;
        /* Limiting the width */
    }

    .category-filter,
    .date-filter {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    label {
        margin-bottom: 5px;
        font-size: 14px;
        color: #333;
    }

    select {
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #ddd;
        background-color: #fff;
        font-size: 14px;
        width: 150px;
        transition: border-color 0.3s ease;
    }

    select:focus {
        outline: none;
        border-color: #007bff;
    }

    /* Apply Filter button */
    button#applyFilter {
        padding: 10px 10px;
        background-color: #28a745;
        border: none;
        border-radius: 8px;
        color: #fff;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        width: fit-content;
        margin: auto;
        /* Centering the button */
    }

    button#applyFilter:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        #searchInput {
            width: 80%;
        }

        .filter-section {
            flex-direction: column;
            gap: 15px;
        }

        select {
            width: 100%;

        }
    }

    /* Custom Select Styling */
    .custom-select {
        position: relative;
        width: 100%;
        margin-bottom: 15px;
    }

    .custom-select select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        font-family: 'Arial', sans-serif;
        border: 1px solid #ccc;
        border-radius: 4px;
        appearance: none;
        background-color: white;
        cursor: pointer;
        color: #555;
    }

    .custom-select:after {
        content: "▼";
        font-size: 14px;
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        pointer-events: none;
        color: #999;
    }

    .custom-select select:focus {
        border-color: #007bff;
    }

    .custom-select select:invalid {
        color: #999;
    }
</style>

<body>
    @include('includes.navbar')

    <header>
        <h1>My Blogs</h1>
        <button id="createBlogBtn">+ Create New Blog</button>
    </header>
    <section class="search-container">
        <input type="text" id="searchInput" placeholder="Search for a blog..." />
    </section>
    <div class="filter-section">
        <div class="category-filter">
            <select id="categoryFilter">
                <option value="">All Categories</option>
                <option value="Technology">Technology</option>
                <option value="Education">Education</option>
                <option value="Politics">Politics</option>
                <option value="Economics">Economics</option>
            </select>
        </div>

        <button id="applyFilter">Apply Filter</button>
    </div>
    <main>
        <!-- Create Blog Modal -->
        <div id="createBlogModal" class="modal" style="display: none;">
            <div class="modal-content">
                <h2>Create Blog</h2>
                <form id="createBlogForm" method="post" action="/Blog/db/request.php">
                    <label>Title:</label>
                    <input type="text" name="title" required>
                    <label for="category">Category:</label>
                    <select class="custom-select" name="category" required>
                        <option value="" disabled selected>Select a category</option>
                        <option value="Technology">Technology</option>
                        <option value="Education">Education</option>
                        <option value="Politics">Politics</option>
                        <option value="Economics">Economics</option>
                    </select>
                    <label>Content:</label>
                    <textarea name="content" rows="3" required></textarea>
                    <button type="submit" onclick="return confirm('Upload the Blog?');">Create</button>
                    <button type="button" name="add_post" class="cancelBtn"
                        onclick="closeModal('#createBlogModal')">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Update Blog Modal -->
        <div id="updateBlogModal" class="modal" style="display: none;">
            <div class="modal-content">
                <h2>Update Blog</h2>
                <form id="updateBlogForm" method="post" action="/Blog/db/request.php">
                    <input type="hidden" name="id" id="BlogId">
                    <label>Title:</label>
                    <input type="text" name="title" id="Updatetitle" required>

                    <label for="category">Category:</label>
                    <select class="custom-select" name="category" id="UpdateCategory" required>
                        <option value="" disabled selected>Select a category</option>
                        <option value="Technology" id="UpdateTech">Technology</option>
                        <option value="Education" id="UpdateEduc">Education</option>
                        <option value="Politics" id="UpdatePolitics">Politics</option>
                        <option value="Economics" id="UpdateEco">Economics</option>
                    </select>

                    <label>Content:</label>
                    <textarea name="content" rows="3" id="UpdateContent" required></textarea>

                    <button type="submit" name="update_post"
                        onclick="return confirm('Update the Blog?');">Update</button>
                    <button type="button" class="cancelBtn" onclick="closeModal('#updateBlogModal')">Cancel</button>
                </form>
            </div>
        </div>


        <!-- Blog List -->
        <section>

            <div class="grid-container" id="gridBlogs">
                <!-- Blog cards will be populated here by JavaScript -->
            </div>
        </section>
    </main>

    @include('includes.footer')

    
</body>

</html>
