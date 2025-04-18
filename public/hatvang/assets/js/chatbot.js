const triggerChatbot = () => {
    const $chatbotContainer = $(".chatbot-container");
    const $minimizeBtn = $(".minimize-btn");
    const $output = $("#outputTextChatbot");
    let hasGreeted = false;

    $minimizeBtn.on("click", function (e) {
        e.stopPropagation();
        $chatbotContainer.addClass("minimized");
    });

    $chatbotContainer.on("click", function () {
        if ($chatbotContainer.hasClass("minimized")) {
            $chatbotContainer.removeClass("minimized");

            if (!hasGreeted) {
                $output.append(`
                        <div class="chatbot-message">Xin chào! Tôi có thể giúp gì cho bạn?</div>
                    `);
                $output.scrollTop($output[0].scrollHeight);
                hasGreeted = true;
            }
        }
    });
}

const handlerChatbot = () => {
    $("#btnSendChatbot").on("click", async function () {
        const inputText = $("#inputTextChatbot").val().trim();
        const $output = $("#outputTextChatbot");
        if (!inputText) return;

        $output.append(`<div class="user-message">${inputText}</div>`);
        $output.scrollTop($output[0].scrollHeight);

        $("#inputTextChatbot").val('').css('height', 'auto');

        const apiKey = "AIzaSyAHjMMMnMWPv4WyQ5gHt9SXQYLP5Hucnok";
        const endpoint = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;

        const $processingMsg = $('<div class="chatbot-message">Đang xử lý...</div>');
        $output.append($processingMsg);
        $output.scrollTop($output[0].scrollHeight);

        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    contents: [{
                        parts: [{ text: inputText }]
                    }]
                })
            });

            if (!response.ok) {
                const error = await response.json();
                $processingMsg.text(`Lỗi: ${error.error.message}`);
                return;
            }

            const result = await response.json();
            const aiResponse = result.candidates[0].content.parts[0].text;
            $processingMsg.text(aiResponse || "Không có phản hồi từ AI.");
            $output.scrollTop($output[0].scrollHeight);

        } catch (error) {
            console.error('Lỗi:', error);
            $processingMsg.text("Lỗi kết nối. Vui lòng thử lại.");
        }
    });
}

$(document).ready(function () {
    triggerChatbot();
    handlerChatbot();
});