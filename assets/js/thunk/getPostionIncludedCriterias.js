import Axios from "axios";
import { setPositionIncludedCriterias } from "../Actions/action";

export const getPositionIncludedCriterias = positionId => (
  dispatch,
  getState
) => {
  Axios.get(`/api/profiles/${positionId}`, {
    headers: { Authorization: `Bearer ${getState().token.token}` }
  })
    .then(res => {
      dispatch(setPositionIncludedCriterias(res.data.criteriaList));
    })
    .catch(err => console.log(err));
};
