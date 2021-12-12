import {CssBaseline} from "@mui/material";
import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import TodoContextProvider from "./contexts/TodoContext";
import TodoTable from "./components/TodoTable";

class App extends Component {
    render() {
        return (
            <TodoContextProvider>
                <CssBaseline>
                    <TodoTable/>
                </CssBaseline>
            </TodoContextProvider>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('root'))

