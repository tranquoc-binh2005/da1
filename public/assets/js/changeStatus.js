$(document).ready(function() {
    const changeSingleStatus = () => {
        $(document).on('change', '.changeStatusPublish', function() {
            let _this = $(this);

            let payload = {
                id: _this.attr('data-id'),
                field: _this.attr('data-field'),
                column: _this.attr('data-column'),
                value: _this.attr('data-publish')
            };

            $.ajax({
                url: '/ajax/changeStatusSingle',
                type: 'POST',
                data: payload,
                success: function (res) {
                    console.log(res.new_publish)
                    if(res.status) {
                        console.log("new publish value " + res.new_publish);

                        // ✅ Cập nhật lại giá trị publish mới vào attr
                        _this.attr('data-publish', res.new_publish);
                    } else {
                        alert('Có lỗi xảy ra: ' + res.message);
                    }
                },
                error: function (e) {

                }
            });
        });
    }

    changeSingleOrderTop = () => {
        $(document).on('change keyup', '.inputOrderTop', function() {
            let _this = $(this);

            let payload = {
                id: _this.attr('data-id'),
                field: _this.attr('data-field'),
                column: _this.attr('data-column'),
                value: _this.val()
            };

            $.ajax({
                url: '/ajax/changeSingleOrderTop',
                type: 'POST',
                data: payload,
                success: function (res) {
                    console.log(res.newOrder)
                },
                error: function (e) {

                }
            });
        });
    }

    changeSingleStatus();
    changeSingleOrderTop();
});