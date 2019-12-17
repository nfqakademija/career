import {
  setFullName,
  setUserId,
  setProfessionId,
  setRoles,
  setLogged,
  setTeams,
  setToken,
  setTitle
} from "../Actions/action";

export const setLoginInfo = data => (dispatch, getState) => {
  const response = data.data;
  dispatch(setFullName(response.firstName + " " + response.lastName));
  dispatch(setUserId(response.id));
  dispatch(setProfessionId(response.professionId));
  dispatch(setRoles(response.roles));
  dispatch(setTitle(response.professionTitle));
  dispatch(setLogged(!getState().user.logged));
  dispatch(setTeams(response.teams));
  dispatch(setToken(data.token));
};
