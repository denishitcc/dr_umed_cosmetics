Formio.use([
    {
        components: {
            rating: sectionBreak
        }
    }
])
Formio.builder(document.getElementById("form-editor"), {}, {
    sanitizeConfig: {
        addTags: ["svg", "path"],
        addAttr: ["d", "viewBox"]
    }
}).then(() => {

});

Formio.createForm(document.getElementById('form-editor'), {
    components: [
        sectionBreak.schema()
    ]
}, {
    sanitizeConfig: {
        addTags: ["svg", "path"],
        addAttr: ["d", "viewBox"]
    }
})
