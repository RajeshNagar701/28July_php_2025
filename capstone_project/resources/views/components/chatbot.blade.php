<!-- AI Chatbot Floating Widget -->
<div id="aiChatbotWidget">
    <!-- Chat Toggle Button -->
    <button id="chatbotToggle" class="btn btn-primary rounded-circle shadow-lg d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; position: fixed; bottom: 30px; right: 30px; z-index: 9999;">
        <i class="bi bi-robot fs-3 text-white"></i>
    </button>

    <!-- Chat Window -->
    <div id="chatbotWindow" class="card shadow-lg border-0 d-none" style="width: 350px; position: fixed; bottom: 100px; right: 30px; z-index: 9999; border-radius: 1rem; overflow: hidden;">
        <!-- Header -->
        <div class="card-header bg-primary text-white p-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-stars fs-4 text-warning"></i>
                <div class="lh-1">
                    <h6 class="mb-0 fw-800">ShoeStore Assistant</h6>
                    <small class="text-white-50" style="font-size:0.7rem;">Powered by Google Gemini AI</small>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" id="chatbotClose"></button>
        </div>
        
        <!-- Conversation Body -->
        <div class="card-body p-3" id="chatbotBody" style="height: 350px; overflow-y: auto; background-color: #f8f9fa;">
            <!-- Initial Bot Message -->
            <div class="d-flex mb-3">
                <div class="bg-primary bg-opacity-10 text-dark rounded-3 py-2 px-3 shadow-sm border border-primary border-opacity-25" style="max-width: 85%; font-size: 0.9rem;">
                    Hi there! 👋 I'm your AI shopping assistant. How can I help you find the perfect pair of shoes today?
                </div>
            </div>
        </div>

        <!-- Input Footer -->
        <div class="card-footer bg-white p-3 border-top">
            <form id="chatbotForm" class="input-group">
                <input type="text" id="chatbotInput" class="form-control border-secondary shadow-none" placeholder="Ask me anything..." required autocomplete="off" style="border-radius: 20px 0 0 20px;">
                <button type="submit" class="btn btn-primary px-3" style="border-radius: 0 20px 20px 0;" id="chatbotSendBtn">
                    <i class="bi bi-send-fill"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const toggleBtn = document.getElementById('chatbotToggle');
    const closeBtn = document.getElementById('chatbotClose');
    const chatWindow = document.getElementById('chatbotWindow');
    const chatForm = document.getElementById('chatbotForm');
    const chatInput = document.getElementById('chatbotInput');
    const chatBody = document.getElementById('chatbotBody');
    const sendBtn = document.getElementById('chatbotSendBtn');

    // Toggle Chat Window
    toggleBtn.addEventListener('click', () => {
        chatWindow.classList.toggle('d-none');
        if(!chatWindow.classList.contains('d-none')){
            chatInput.focus();
        }
    });

    closeBtn.addEventListener('click', () => {
        chatWindow.classList.add('d-none');
    });

    // Handle Formatting Helper
    function formatText(text) {
        if (!text) return "";
        // Convert **bold** to <strong> and handle newlines
        return text
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>');
    }

    function appendMessage(sender, text) {
        const div = document.createElement('div');
        div.className = sender === 'user' 
            ? 'd-flex justify-content-end mb-3' 
            : 'd-flex mb-3';

        const bubbleClass = sender === 'user' 
            ? 'bg-primary text-white rounded-3 py-2 px-3 shadow-sm'
            : (sender === 'error' ? 'bg-danger bg-opacity-10 text-danger rounded-3 py-2 px-3 shadow-sm border border-danger border-opacity-25' : 'bg-primary bg-opacity-10 text-dark rounded-3 py-2 px-3 shadow-sm border border-primary border-opacity-25');

        div.innerHTML = `<div class="${bubbleClass}" style="max-width: 85%; font-size: 0.9rem;">${formatText(text)}</div>`;
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // Submit Action
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const msg = chatInput.value.trim();
        if(!msg) return;

        // Append User Message
        appendMessage('user', msg);
        chatInput.value = '';
        chatInput.disabled = true;
        sendBtn.disabled = true;

        // Add typical AI Loading indicator
        const loadingId = 'loading-' + Date.now();
        const loadingDiv = document.createElement('div');
        loadingDiv.id = loadingId;
        loadingDiv.className = 'd-flex mb-3 align-items-center gap-2 text-muted small px-2';
        loadingDiv.innerHTML = `<div class="spinner-grow spinner-grow-sm text-primary" role="status"></div> <span>Assistant is thinking...</span>`;
        chatBody.appendChild(loadingDiv);
        chatBody.scrollTop = chatBody.scrollHeight;

        try {
            const response = await fetch("{{ route('chatbot.chat') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: msg })
            });
            const data = await response.json();
            
            // Remove Loader
            const loader = document.getElementById(loadingId);
            if(loader) loader.remove();
            
            if (data.success) {
                appendMessage('bot', data.reply);
            } else {
                appendMessage('error', data.reply || "Something went wrong.");
            }

        } catch (error) {
            const loader = document.getElementById(loadingId);
            if(loader) loader.remove();
            appendMessage('error', 'Network error. Please check your connection or restart the server.');
        } finally {
            chatInput.disabled = false;
            sendBtn.disabled = false;
            chatInput.focus();
        }
    });
});
</script>
