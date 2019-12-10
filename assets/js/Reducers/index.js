import { combineReducers } from 'redux';
import { profilesList } from './profilesList';
import { managerPage } from './managerPage';
import { user } from './User';
import { trackUserChanges } from './trackUserChanges';
//rootReducer

const appReducer = combineReducers({
    profilesList,
    managerPage,
    user,
    trackUserChanges
})

export const allReducer = (state, action) =>{
    if(action.type === "RESET_APP"){
        state = undefined;
    }

    return appReducer(state, action);
}