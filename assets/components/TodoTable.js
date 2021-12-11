import React, {useContext} from 'react';
import {TodoContext} from "../contexts/TodoContext";
import Table from "@mui/material/Table";
import TableRow from "@mui/material/TableRow";
import TableHead from "@mui/material/TableHead";
import TableCell from "@mui/material/TableCell";
import TableBody from "@mui/material/TableBody";
import IconButton from "@mui/material/IconButton";
import EditIcon from '@mui/icons-material/Edit';
import DeleteIcon from '@mui/icons-material/Delete';
import AddIcon from '@mui/icons-material/Add';
import TextField from "@mui/material/TextField";

function TodoTable() {
    const context = useContext(TodoContext)
    return (
        <Table>
            <TableHead>
                <TableRow>
                    <TableCell>
                        Tasks
                    </TableCell>
                    <TableCell align="right">
                        Actions
                    </TableCell>
                </TableRow>
            </TableHead>
            <TableBody>
                <TableRow>
                    <TableCell>
                        <TextField fullWidth={true} />
                    </TableCell>
                    <TableCell align="right">
                        <IconButton>
                            <AddIcon/>
                        </IconButton>
                    </TableCell>
                </TableRow>
                {context.todos.map(todo => (
                    <TableRow>
                        <TableCell>{todo.name}</TableCell>
                        <TableCell align="right">
                            <IconButton>
                                <EditIcon />
                            </IconButton>
                            <IconButton>
                                <DeleteIcon />
                            </IconButton>
                        </TableCell>
                    </TableRow>
                ))}
            </TableBody>
        </Table>
    );
}

export default TodoTable;