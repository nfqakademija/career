const initialState = {
  email: "",
  name: null,
  userId: null,
  title: null,
  formId: null,
  professionId: null,
  roles: []
};

export const user = (state = initialState, action) => {
  switch (action.type) {
    case "setEmail":
      return {
        ...state,
        email: action.email
      };
    case "setFullName":
      return {
        ...state,
        name: action.name
      };
    case "setUserId":
      return {
        ...state,
        userId: action.userId
      };
    case "setTitle":
      return {
        ...state,
        title: action.title
      };
    case "setCareerFormId":
      return {
        ...state,
        formId: action.formId
      };
    case "setProfessionId":
      return {
        ...state,
        professionId: action.professionId
      };
    case "setRoles":
      return {
        ...state,
        roles: action.roles
      };

    default:
      return state;
  }
};
