
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

    class SEOBlock extends React.Component {
        constructor(props) {
            super(props);

            this.state = {
                seoTitle: props.title
            };
        }
        render() {
            return (
                <div className="row seo-block" >
                    <h1 className="col-lg-12">
                        {this.state.seoTitle}
                    </h1>
                </div>
            );
        }
    }

    class HomePage extends Page {
        constructor(props) {
            super(props);

            this.state = {
                title: "asdasdasdasd"
            };
        }

        render() {
            return (
                <div className="container">
                    <SEOBlock title={this.state.title} />
                </div>
            );
        }
    }

    ReactDOM.render(
        <HomePage />,
        document.getElementById('root')
    );
</script>