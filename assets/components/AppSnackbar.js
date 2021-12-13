import React, {Fragment, useContext} from 'react';
import Snackbar from "@mui/material/Snackbar";
import SnackbarContent from "@mui/material/SnackbarContent";
import {TodoContext} from "../contexts/TodoContext";
import Button from "@mui/material/Button";

function checkLevel(level) {
    switch (level) {
        case 'success':
            return 'green';
        case 'error':
            return 'red';
        case 'warning':
            return 'yellow'
        default:
            return 'white';
    }
}

function AppSnackbar() {
    const context = useContext(TodoContext);
    return (
        <Snackbar autoHideDuration={6000} open={context.message.text !== undefined}>
            {context.message.text && (
                <SnackbarContent
                    style={{backgroundColor: checkLevel(context.message.level)}}
                    message={context.message.text.map((text, index) => (
                    <Fragment key={index + ' ' + index}>
                        <span>{text}</span>
                        <br/>
                    </Fragment>
                    ))}
                    action={[
                    <Button
                        onClick={() => {context.setMessage({})}}
                        key='dismiss'
                        color='inherit'
                    >
                        dismiss
                    </Button>
                ]}/>
            )}
        </Snackbar>
    );
}

export default AppSnackbar;