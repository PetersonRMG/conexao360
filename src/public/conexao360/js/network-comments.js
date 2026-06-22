document.addEventListener(
    'DOMContentLoaded',
    function ()
    {
        const counters =
            document.querySelectorAll(
                '.comments-counter'
            );

        counters.forEach(function(item)
        {
            item.addEventListener(
                'click',
                function ()
                {
                    const feedId =
                        this.getAttribute(
                            'data-feed-id'
                        );

                    const modal =
                        document.getElementById(
                            'commentsModal' +
                            feedId
                        );

                    if(modal)
                    {
                        modal.classList.add(
                            'active'
                        );
                    }
                }
            );
        });

        const closeButtons =
            document.querySelectorAll(
                '.comments-close'
            );

        closeButtons.forEach(function(btn)
        {
            btn.addEventListener(
                'click',
                function ()
                {
                    const feedId =
                        this.getAttribute(
                            'data-close-modal'
                        );

                    const modal =
                        document.getElementById(
                            'commentsModal' +
                            feedId
                        );

                    if(modal)
                    {
                        modal.classList.remove(
                            'active'
                        );
                    }
                }
            );
        });
    }
);