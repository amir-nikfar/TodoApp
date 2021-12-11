import React, {Component, createContext} from 'react';

export const TodoContext = createContext()

class TodoContextProvider extends Component {
    constructor(props) {
        super(props);
        this.state = {
            todos: [
                {name: 'do something'},
                {name: 'do something'},
                {name: 'do something'},
                {name: 'do something'},
                {name: 'do something'},
                {name: 'do something'},
                {name: 'do something'},
            ]
        };
    }

    // Create
    createTodo() {

    }
    // Read
    readTodo() {

    }
    // Update
    updateTodo() {

    }
    // Delete
    deleteTodo() {

    }

    render() {
        return (
            <TodoContext.Provider value={{
                ...this.state,
                createTodo: this.createTodo.bind(this),
                updateTodo: this.updateTodo.bind(this),
                deleteTodo: this.deleteTodo.bind(this)
            }}>
                {this.props.children}
            </TodoContext.Provider>
        );
    }
}
export default TodoContextProvider;