
          
                var Bloodhound = require('./bloodhound.jquery.min.js');
                var works = new Bloodhound(
                {
                    datumTokenizer: Bloodhound.tokenizers.whitespace,
                    queryTokenizer: Bloodhound.tokenizers.whitespace,

                    remote: {
                        url: "{{ path('handle_search') }}/%QUERY%",
                        wildcard: '%QUERY%',
                        filter: function (works)
                        {
                            return $.map(works, function (work)
                            {
                                return {
                                    film_title: work.title,
                                   
                                }
                            })
                        }
                    }
                })

                works.initialize();

                $('#form_query').typeahead(
                {
                    hint: true
                },
                {
                    name: 'works',
                    source: works.ttAdapter(),
                    display: 'title',
                    templates: {
                        suggestion: function (data)
                        {
                            return `
                                <div>
                                   
                                    <span>`+data.title+`</span>
                                </div>
                            `
                        },
                        footer: function (query)
                        {
                            return '<div class="text-center">More results about: '+ query.query +'</div>'
                        }
                    }
                })

