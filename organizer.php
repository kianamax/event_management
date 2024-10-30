<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Organizer Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        :root {
            --purple: #9C27B0;
            --deep-purple: #2D0A31;
            --dark-gray: #1A1A1A;
            --input-bg: #333;
        }
        body {
            background-color: var(--deep-purple);
            color: white;
        }
        .btn-primary {
            background-color: var(--purple);
        }
        .btn-primary:hover {
            background-color: #7B1FA2;
        }
        input, textarea {
            background-color: var(--input-bg);
            color: white;
            border: none;
        }
    </style>
</head>
<body class="min-h-screen">
    <nav class="bg-gray-900 p-4">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold">Event Organizer Dashboard</h1>
        </div>
    </nav>

    <main class="container mx-auto mt-8">
        <form id="createEventForm" class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Create New Event</h2>
            <div class="mb-4">
                <label for="eventName" class="block mb-2">Event Name</label>
                <input type="text" id="eventName" name="eventName" class="w-full p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label for="eventDate" class="block mb-2">Event Date</label>
                <input type="date" id="eventDate" name="eventDate" class="w-full p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label for="eventVenue" class="block mb-2">Venue</label>
                <input type="text" id="eventVenue" name="eventVenue" class="w-full p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label for="ticketPrice" class="block mb-2">Ticket Price</label>
                <input type="number" id="ticketPrice" name="ticketPrice" class="w-full p-2 rounded" required>
            </div>
            <div class="mb-4">
                <label for="eventPoster" class="block mb-2">Event Poster</label>
                <input type="file" id="eventPoster" name="eventPoster" accept="image/*" class="w-full p-2 rounded" required>
            </div>
            <button type="submit" class="btn-primary px-4 py-2 rounded">Create Event</button>
        </form>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
    document.getElementById('createEventForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        try {
            const response = await axios.post('create_event.php', formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            });
            alert('Event created successfully!');
            e.target.reset();
        } catch (error) {
            alert('Error creating event. Please try again');
            console.error(error);
        }
    });
</script>

</body>
</html>
