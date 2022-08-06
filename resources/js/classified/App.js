import {Provider} from "react-redux";
import store from "./store";
import Routes from "./routes";
import Layout from "./components/layout";

function App() {
    return (
        <Provider store={store}>
            <Layout>
                <Routes />
            </Layout>
        </Provider>
    );
}

export default App;
