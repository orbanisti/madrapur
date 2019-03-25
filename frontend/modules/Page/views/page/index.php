
<div id="root"></div>

<script type="text/babel">
    class Page extends React.Component {		
        constructor(props) {
            super(props);

            this.state = {
                
            };
        }

        render() {
            return (
                <div className="container">
                    here comes the sun
                </div>           			
            );              
        }	
    }

    ReactDOM.render(
        <Page />,
        document.getElementById('root')
    );
</script>