import {Component} from "react";
import withRouter from "../components/withRouter";

class About extends Component {
    constructor(props) {
        super(props);
        console.log(props);
    }

    render() {
        return (
            <>
                <h1>About Us</h1>
                {this.props.router.params.id && <p>{this.props.router.params.id}</p>}
            </>
        );
    }
}

export default withRouter(About);
