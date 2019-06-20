

<div id="root"></div>

<style>
  pre {outline: 1px solid #ccc; padding: 5px; margin: 5px; }
  .string { color: green; }
  .number { color: darkorange; }
  .boolean { color: blue; }
  .null { color: magenta; }
  .key { color: red; }
</style>

<script type="text/babel">
    class ReservationsCreate extends React.Component {		
        constructor(props) {
            super(props);

            const input = <?php echo $data; ?>;
            console.warn(input);

            this.state = {
              data: input,
            };
        }

        syntaxHighlight(json) {
            if (typeof json != 'string') {
                json = JSON.stringify(json, undefined, 2);
            }
            json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                var cls = 'number';
                if (/^"/.test(match)) {
                    if (/:$/.test(match)) {
                        cls = 'key';
                    } else {
                        cls = 'string';
                    }
                } else if (/true|false/.test(match)) {
                    cls = 'boolean';
                } else if (/null/.test(match)) {
                    cls = 'null';
                }
                return '<span class="' + cls + '">' + match + '</span>';
            });
        }

        render() {
          const { data } = this.state;
          const dataText = this.syntaxHighlight(data);
          
            return (
              <div className="container">
                

                <div id="rDebug" dangerouslySetInnerHTML={{ __html: dataText }} />
              </div>           			
            );              
        }	
    }

    ReactDOM.render(
        <ReservationsCreate />,
        document.getElementById('root')
    );
</script>