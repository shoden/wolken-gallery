cmake_minimum_required(VERSION 2.6)

project(wolken-gallery)

set(CMAKE_INSTALL_PREFIX /usr)
set(GALLERY_DIR share/wolken-gallery/gal)

# Register all files
file(GLOB _a src/*.php)
file(GLOB _b src/backend/*.php)
file(GLOB _c src/css/*.css)
file(GLOB _d src/img/*.*)
file(GLOB _e src/img/cal/*.*)
file(GLOB _f src/inc/*.*)
file(GLOB _g src/js/*.*)

# Install all files
foreach(a ${_a}) 
  install(FILES ${a} DESTINATION ${GALLERY_DIR})
endforeach()

foreach(b ${_b})
  install(FILES ${b} DESTINATION ${GALLERY_DIR}/backend)
endforeach()

foreach(c ${_c})
  install(FILES ${c} DESTINATION ${GALLERY_DIR}/css)
endforeach()

foreach(d ${_d})
  install(FILES ${d} DESTINATION ${GALLERY_DIR}/img)
endforeach()

foreach(e ${_e})
  install(FILES ${e} DESTINATION ${GALLERY_DIR}/img/cal)
endforeach()

foreach(f ${_f})
  install(FILES ${f} DESTINATION ${GALLERY_DIR}/inc)
endforeach()

foreach(g ${_g})
  install(FILES ${g} DESTINATION ${GALLERY_DIR}/js)
endforeach()

# Install Apache2 configuration file
set(APACHE2_CONF conf/apache.conf)
install(FILES ${CMAKE_CURRENT_SOURCE_DIR}/${APACHE2_CONF} DESTINATION /etc/wolken-gallery)

# Uninstall target
configure_file(
    "${CMAKE_CURRENT_SOURCE_DIR}/cmake_uninstall.cmake.in"
    "${CMAKE_CURRENT_BINARY_DIR}/cmake_uninstall.cmake"
    IMMEDIATE @ONLY)

add_custom_target(uninstall
    COMMAND ${CMAKE_COMMAND} -P ${CMAKE_CURRENT_BINARY_DIR}/cmake_uninstall.cmake)
